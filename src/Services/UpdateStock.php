<?php
namespace App\Services;

use App\Entity\MgMovementsStocks;
use App\Entity\MgProducts;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UpdateStock extends AbstractController
{
	public function updateStock(MgProducts $product, $movement, $info, $quantity)
	{
		$movements = new MgMovementsStocks();
		$movements->setProduct($product);
		$movements->setMovement($movement);
		$movements->setInfo($info);
		$movements->setQuantity($quantity);
		$em = $this->getDoctrine()->getManager();
		$em->persist($movements);
	    $em->flush();
	}

	public function updateQuantityProduct(MgProducts $product, $quantity, $orderNum)
	{
		$product->setQuantity($product->getQuantity() - $quantity);
		$em = $this->getDoctrine()->getManager();
		$em->persist($product);
		$em->flush();
		
		$info = 'Commande numéro ' . $orderNum;

		$this->updateStock($product, ($quantity * -1), $info, $product->getQuantity());
	}
}