<?php

namespace App\Entity;

use App\Repository\ProductsImagesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductsImagesRepository::class)
 */
class ProductsImages
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=MgProducts::class, inversedBy="images")
     */
    private $product;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?MgProducts
    {
        return $this->product;
    }

    public function setProduct(?MgProducts $product): self
    {
        $this->product = $product;

        return $this;
    }
}
