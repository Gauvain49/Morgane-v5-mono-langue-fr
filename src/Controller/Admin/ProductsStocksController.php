<?php

namespace App\Controller\Admin;

use App\Entity\MgProducts;
use App\Form\ProductsStocksType;
use App\Services\UpdateStock;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/products/stock")
 */
class ProductsStocksController extends AbstractController
{
    /**
     * @Route("/{id}", name="products_stocks_index", requirements={"id"="\d+"})
     */
    public function index(MgProducts $product, Request $request, UpdateStock $movements): Response
    {
        $form = $this->createForm(ProductsStocksType::class, $product);
        $quantity = $product->getStockQuantity();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $updateQuantity = $request->get('update_quantity');
            if (!empty($updateQuantity) || $updateQuantity != 0) {
                $product->setStockQuantity($quantity + $updateQuantity);
                if ($updateQuantity > 0) {
                    $info = "Ajout au stock.";
                } elseif ($updateQuantity < 0) {
                    $info = "Retrait du stock.";
                }
                $changeQuantity = $updateQuantity;

            } else {
                $info = 'Modification manuelle.';
                $changeQuantity = $product->getStockQuantity();
            }
            $movements->updateStock($product, $changeQuantity, $info, $product->getStockQuantity());
            $entityManager->persist($product);
            $entityManager->flush();

            $this->addFlash(
                'success',
                "Modification réussie !"
            );

            return $this->redirectToRoute('products_stocks_index', ['id' => $product->getId()]);
        }
        return $this->render('admin/products/stocks/index.html.twig', [
            'product' => $product,
            'id' => $product->getId(),
            'form' => $form->createView(),
            'NavCatalogOpen' => true
        ]);
    }
}
