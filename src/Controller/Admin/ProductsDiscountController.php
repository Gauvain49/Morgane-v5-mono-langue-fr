<?php

namespace App\Controller\Admin;

use App\Entity\MgProducts;
use App\Form\ProductsDiscountType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/products/discount")
 */
class ProductsDiscountController extends AbstractController
{
    /**
     * @Route("/{id}", name="products_discount_index", requirements={"id"="\d+"})
     */
    public function index(MgProducts $product, Request $request): Response
    {
        $form = $this->createForm(ProductsDiscountType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
        	$entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            $this->addFlash(
                'success', 'Modification réussie !'
            );
            return $this->redirectToRoute('products_discount_index', [
                'id' => $product->getId()
                ]
            );
        }
        return $this->render('admin/products/discount/index.html.twig', [
            'product' => $product,
            'id' => $product->getId(),
            'form' => $form->createView(),
            'NavCatalogOpen' => true
        ]);
    }
}
