<?php

namespace App\Entity;

use App\Repository\MgTaxesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MgTaxesRepository::class)
 */
class MgTaxes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $taxe_name;

    /**
     * @ORM\Column(type="float")
     */
    private $taxe_rate;

    /**
     * @ORM\OneToMany(targetEntity=MgProducts::class, mappedBy="taxe")
     */
    private $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTaxeName(): ?string
    {
        return $this->taxe_name;
    }

    public function setTaxeName(string $taxe_name): self
    {
        $this->taxe_name = $taxe_name;

        return $this;
    }

    public function getTaxeRate(): ?float
    {
        return $this->taxe_rate;
    }

    public function setTaxeRate(float $taxe_rate): self
    {
        $this->taxe_rate = $taxe_rate;

        return $this;
    }

    /**
     * @return Collection|MgProducts[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(MgProducts $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setTaxe($this);
        }

        return $this;
    }

    public function removeProduct(MgProducts $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getTaxe() === $this) {
                $product->setTaxe(null);
            }
        }

        return $this;
    }
}
