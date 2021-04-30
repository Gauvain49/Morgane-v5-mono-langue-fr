<?php

namespace App\Controller\Admin;

use App\Entity\MgProducts;
use App\Entity\MgProductsImages;
use App\Repository\MgProductsImagesRepository;
use App\Repository\MgProductsRepository;
use App\Services\ResizeImg;
use App\Services\qqFileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/products/images")
 */
class ProductsImagesController extends AbstractController
{
    /**
     * @Route("/{id}", name="products_images_index")
     */
    public function index(Request $request, MgProducts $product, MgProductsImagesRepository $imagesRepository): Response
    {
    	$images = $imagesRepository->findByProduct($product->getId());
        $imgPath = [];
        foreach ($images as $value) {
            //$imgPath[$value->getId()] = $imagesRepository->getImgBySize($this->getParameter('upload_directory_products') . '/', $product->getId(), $imagesRepository::SMALL, 'square');
            $imgPath[$value->getId()] = $product->getId() . $value->getPosition();
        }
        return $this->render('admin/products/images/index.html.twig', [
            'product' => $product,
            'id' => $product->getId(),
            'images' => $images,
            'imgPath' => $imgPath,
            'NavCatalogOpen' => true
        ]);
    }

    /**
     * @Route("/{id}/image_upload", name="products_images_upload", requirements={"id"="\d+"})
     */
    public function imageUpload(MgProductsRepository $productsRepository, MgProductsImagesRepository $imagesRepository, ResizeImg $resize, Request $request)
    {
        $id = $request->query->get('id_product');
        $product = $productsRepository->find($id);
        $productImg = new MgProductsImages;

        $em = $this->getDoctrine()->getManager();
        $productImg->setProduct($product);

        //Pour définir une position, On vérifie si au moins une image existe déjà
        $ifProductExist = $imagesRepository->findOneByProduct($product, ['position' => 'DESC']);
        //Si aucune image n'existe, on la met en cover et en position 1
        if (empty($ifProductExist)) {
        	$position = 1;
            $productImg->setCover(true);
            $productImg->setPosition($position);
        } else {
        	$position = $ifProductExist->getPosition()+1;
            $productImg->setCover(false);
            $productImg->setPosition($position);
        }
        $productImg->setImageName($product->getSlug());

        // liste des extensions valides, ex. array("jpeg", "xml", "bmp")
        $allowedExtensions = array('jpg', 'jpeg', 'gif', 'png');
        // taille max du fichier en bytes
        $sizeLimit = 10 * 1024 * 1024;
        $uploader = new qqFileUploader($product->getSlug(), $allowedExtensions, $sizeLimit);
        // Call handleUpload() with the name of the folder, relative to PHP's getcwd()
        /**
         * Construction du chemin de l'image :
         * path = public/img/p
		 * concaténé avec l'id du produit éclaté en dossier
		 * (Ex : si id du produit = 2039)
		 * path .= /2/0/3/9
		 * concaténé avec l'ordre de l'image
		 * (Ex : si 2 images ont déjà été transféré)
		 * path .= /3
		 */

        //Création du/des dossiers avec l'id du produit
        $path = $product->getId() . $position;
        $field = $this->getParameter('upload_directory_products') . '/';
        $splitId = str_split($path);
        foreach($splitId as $split) {
            $field .= $split . '/';
            if(!is_dir($field)) {
                mkdir($field, 0777, true);
            }
        }
        $result = $uploader->handleUpload($field);
        $_SESSION['resultat'][] = $result;
        if (!array_key_exists('error', $result)) {
            //On récupère et donne ensuite le vrai type mime
            $size = getimagesize($field . $result['newFilename']);
            $productImg->setMimeType($size['mime']);
            $em->persist($productImg);
            $em->flush();
        } /*else {
            $em->remove($productImg);
            $em->flush();
        }*/

    	return new JsonResponse($result);
    }
}
