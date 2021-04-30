<?php

namespace App\Controller\Admin;

use App\Entity\MgProducts;
use App\Form\ProductsType;
use App\Repository\MgProductsRepository;
use App\Repository\MgPropertiesRepository;
use App\Repository\MgTaxesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/products")
 */
class ProductsController extends AbstractController
{
    /**
     * @Route("/", name="products_index", methods={"GET"})
     */
    public function index(MgProductsRepository $ProductsRepository): Response
    {
        return $this->render('admin/products/index.html.twig', [
            'products' => $ProductsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="products_new", methods={"GET","POST"})
     */
    public function new(Request $request, MgPropertiesRepository $repoProperties, MgTaxesRepository $repoTaxes): Response
    {
        $product = new MgProducts();
        $taxeDefault = $repoTaxes->find(3);
        $product->setTaxe($taxeDefault);
        $form = $this->createForm(ProductsType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            if (($task->getMinQuantity() < $task->getSalesUnit()) && ($task->getMinQuantity() > 0)) {
                $form->get('min_quantity')->addError(new FormError("Ne peut etre inférieure à unité de vente'"));

                $this->addFlash(
                    'danger', 'Le produit contient des erreurs.'
                );
            } elseif(($task->getMaxQuantity() < $task->getSalesUnit()) && ($task->getMaxQuantity() > 0)) {
                $form->get('max_quantity')->addError(new FormError("Ne peut etre inférieure à unité de vente'"));

                $this->addFlash(
                    'danger', 'Le produit contient des erreurs.'
                );
            } else {
                $entityManager = $this->getDoctrine()->getManager();
                //Si l'unité de vente est rempli mais pas le minimum commande, ce dernier prend la valeur de l'unité de vente
                if (!empty($task->getSalesUnit()) && empty($task->getMinQuantity())) {
                    $product->setMinQuantity($task->getSalesUnit());
                }
                foreach ($product->getCategories() as $category) {
                    $product->addCategory($category);
                }
                foreach ($product->getProductsProperties() as $k => $property) {
                    if (is_null($property->getCustom()) && is_null($property->getPropertyValue())) {
                        //$property = null;
                        unset($product->getProductsProperties()[$k]);
                    } else {
                        $property->setProduct($product);
                        $entityManager->persist($property);
                    }
                }
                $product->setSellOutOfStock(false);
                $product->setStockQuantity(0);
                //$this->getUser() reprend automatiquement dans un controller l'utilisateur connecté
                $entityManager->persist($product);
                $entityManager->flush();

                $this->addFlash(
                    'success', 'Création réussie !'
                );

                return $this->redirectToRoute('products_edit', [
                    'id' => $product->getId()
                ]);
            }
        }

        return $this->render('admin/products/new.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
            'properties' => $repoProperties->findAll(),
            'NavCatalogOpen' => true
        ]);
    }

    /**
     * @Route("/{id}/edit", name="products_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, MgProducts $product, MgPropertiesRepository $repoProperties): Response
    {
        $form = $this->createForm(ProductsType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
                foreach ($product->getProductsProperties() as $property) {
                    if (!is_null($value->getCustom()) && ($value->getPropertyValue())) {
                        $property->setProduct($product);
                        $entityManager->persist($property);
                    }
                }

            $this->addFlash(
                'success', 'Modification réussie !'
            );

            return $this->redirectToRoute('products_edit', ['id' => $product->getId()]);
        }

        return $this->render('admin/products/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
            'properties' => $repoProperties->findAll(),
            'NavCatalogOpen' => true
        ]);
    }

    /**
     * @Route("/{id}", name="products_delete", methods={"DELETE"})
     */
    public function delete(Request $request, MgProducts $product): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('products_index');
    }
}
