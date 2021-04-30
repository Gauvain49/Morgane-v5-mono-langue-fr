<?php

namespace App\Controller\Admin;

use App\Entity\MgProducts;
use App\Services\AppService;
use App\Services\DeleteItems;
use App\Services\qqFileUploader;
use App\Entity\MgProductsNumericals;
use App\Services\DownloadFileService;
use App\Form\ProductsDownloadableType;
use App\Repository\MgProductsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MgProductsNumericalsRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/product/numerical")
 */
class ProductsNumericalsController extends AbstractController
{
    /**
     * @Route("/{id}/edit", name="products_numerical_index")
     */
    public function index(MgProducts $product, MgProductsRepository $productsRepository, MgProductsNumericalsRepository $productNumericalRepository, Request $request): Response
    {
        $product_numerical = $productsRepository->findOneBy(['parent' => $product, 'type' => [$product::TYPE_DOWNLOADABLE, $product::TYPE_DOWNLOADABLE_EXCLU]]);
        $numerical = $productNumericalRepository->findOneByProduct($product_numerical);
        //dd($numerical);
        if (!is_null($numerical)) {
            $filename = $numerical->getUseFilename();
        } else {
            $filename = false;
        }
        $form = $this->createForm(ProductsDownloadableType::class, $product_numerical);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            foreach ($product_numerical->getProductsNumericals() as $digital) {
                $digital->setProduct($product_numerical);
                if ($digital->getIsExclusive()) {
                    $product_numerical->setType($product::TYPE_DOWNLOADABLE_EXCLU);
                } else {
                    $product_numerical->setType($product::TYPE_DOWNLOADABLE);
                }
                //dump($digital->getExclusive());
                $em->persist($digital);
            }
            //dd($product_numerical->getNumericals());
            $em->persist($product_numerical);
            $em->flush();

            $this->addFlash(
                'success', 'Modification réussie !'
            );
            //Redirection
            return $this->redirectToRoute('products_numerical_index', [
                'id' => $product->getId()
                ]
            );
        }
        return $this->render('admin/products/numericals/index.html.twig', [
            'product' => $product,
            'numerical' => $numerical,
            'form' => $form->createView(),
            'filename' => $filename,
            'NavCatalogOpen' => true
        ]);
    }

    /**
     * @Route("/{id}/upload", name="products_numerical_upload", requirements={"id"="\d+"})
     */
    public function numericalUpload(MgProducts $productParent, Request $request)
    {
        $id = $request->query->get('id_product');
        $product = new MgProducts();
        $numerical = new MgProductsNumericals();
        $filename_origine = $request->query->get('qqfile');
        $filename = md5(uniqid());

        $em = $this->getDoctrine()->getManager();
        //Création du nouveau produit enfant
        $product->setName($productParent->getName() . ' - version numérique');
        $product->setDescription($productParent->getDescription());
        $product->setReference($productParent->getReference());
        $product->setParent($productParent);
        $product->setTaxe($productParent->getTaxe());
        $product->setSellingPrice($productParent->getSellingPrice());
        $product->setSellingPriceAllTaxes($productParent->getSellingPriceAllTaxes());
        $product->setSalesUnit(1);
        $product->setMinQuantity(1);
        $product->setSellOutOfStock(false);
        $product->setStockQuantity(0);
        $product->setStockManagement(false);
        $product->setPreOrder(false);
        $product->setOffline(true);
        $product->setDatePublish($productParent->getDatePublish());
        //$product_numerical->setUser($this->getUser());
        //$product->addReviser($this->getUser());
        $product->setType('downloadable');
        $em->persist($product);
        $em->flush();

        //Création de la version numérique
        $numerical->setProduct($product);
        $numerical->setFilename($filename);
        $numerical->setUseFilename($filename_origine);
        $numerical->setIsExclusive(false);
        //$numerical->setActivate(0);
        $em->persist($numerical);
        $em->flush();
        //On complique le nom du dossier en le hachant
        $id_numerical = hash_hmac('sha256', $numerical->getId(), 'XB240061119133vc79', false);

        // list of valid extensions, ex. array("jpeg", "xml", "bmp")
        $allowedExtensions = array();
        // max file size in bytes
        $sizeLimit = 10 * 1024 * 1024;
        $uploader = new qqFileUploader($filename_origine, $allowedExtensions, $sizeLimit, $filename);

        $field = $this->getParameter('upload_directory_numericals') . "/$id_numerical/";
        if(!is_dir($field)) {
            mkdir($field, 0777);
        }
        $result = $uploader->handleUpload($field);
        $_SESSION['resultat'][] = $result;
        // to pass data through iframe you will need to encode all html tags
        //echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);

        return new JsonResponse($result);
    }

    /**
     * @Route("/{id}/{file}", name="products_download_numeric")
     */
    public function loadFileNumeric($id, $file, DownloadFileService $download)
    {
        return $download->downloadNumerical($id, $file);
    }

    /**
     * @Route("/{id}", name="products_numerical_delete", requirements={"id"="\d+"}, methods="DELETE")
     */
    public function delete(Request $request, MgProductsNumericals $numerical, MgProductsRepository $productsRepository, DeleteItems $deleteItems, AppService $app)
    {
        $id_product = $numerical->getProduct()->getId();
        //$product_numerical = $productsRepository->findOneBy(['id' => $id_product, 'type' => 'downloadable']);
        //$id_parent = $product_numerical->getParent()->getId();

        //$filename = $numerical->getFilename();
        //$field = $app->getHashHmac($numerical->getId());
        
        if ($this->isCsrfTokenValid('delete'.$numerical->getId(), $request->request->get('_token'))) {
            $product_numerical = $productsRepository->findOneBy(['id' => $id_product, 'type' => 'downloadable']);
            $id_parent = $product_numerical->getParent()->getId();
            $this->actionDelete($numerical, $productsRepository, $deleteItems, $app);

            $this->addFlash(
                'success',
                "Le format numérique est supprimé."
            );
        }

        return $this->redirectToRoute('products_numerical_index', ['id' => $id_parent]);
    }

    /**
     * @Route("/{id}/numerical_dell", name="action_products_numerical_delete", requirements={"id"="\d+"}, methods="DELETE")
     */
    public function actionDelete(MgProductsNumericals $numerical, MgProductsRepository $productsRepository, DeleteItems $deleteItems, AppService $app)
    {
        
        //if ($this->isCsrfTokenValid('delete'.$numerical->getId(), $request->request->get('_token'))) {
            $id_product = $numerical->getProduct()->getId();
            $product_numerical = $productsRepository->findOneBy(['id' => $id_product, 'type' => 'downloadable']);
    
            $filename = $numerical->getFilename();
            $field = $app->getHashHmac($numerical->getId());

            $em = $this->getDoctrine()->getManager();
            $em->remove($product_numerical);
            $em->remove($numerical);
            $em->flush();
            /**
             * Effacement du dossier du serveur            
             */
            $path = $this->getParameter('upload_directory_numericals') . '/' . $field;

            $deleteItems->deleteNumerical($path, $filename);
            /*$this->addFlash(
                'success',
                "Le format numérique est supprimé."
            );*/
        //}

        //return $this->redirectToRoute('products_numerical_index', ['id' => $id_parent]);
    }
}
