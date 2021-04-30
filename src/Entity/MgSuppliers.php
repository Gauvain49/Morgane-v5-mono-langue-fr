<?php

namespace App\Entity;

use App\Repository\MgSuppliersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MgSuppliersRepository::class)
 */
class MgSuppliers
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $supplier_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $supplier_address;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $supplier_zipcode;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $supplier_town;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $supplier_phone;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $supplier_email;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $supplier_web;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $supplier_logo;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $supplier_note;

    /**
     * @ORM\OneToMany(targetEntity=MgProducts::class, mappedBy="supplier")
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

    public function getSupplierName(): ?string
    {
        return $this->supplier_name;
    }

    public function setSupplierName(string $supplier_name): self
    {
        $this->supplier_name = $supplier_name;

        return $this;
    }

    public function getSupplierAddress(): ?string
    {
        return $this->supplier_address;
    }

    public function setSupplierAddress(?string $supplier_address): self
    {
        $this->supplier_address = $supplier_address;

        return $this;
    }

    public function getSupplierZipcode(): ?string
    {
        return $this->supplier_zipcode;
    }

    public function setSupplierZipcode(?string $supplier_zipcode): self
    {
        $this->supplier_zipcode = $supplier_zipcode;

        return $this;
    }

    public function getSupplierTown(): ?string
    {
        return $this->supplier_town;
    }

    public function setSupplierTown(?string $supplier_town): self
    {
        $this->supplier_town = $supplier_town;

        return $this;
    }

    public function getSupplierPhone(): ?string
    {
        return $this->supplier_phone;
    }

    public function setSupplierPhone(?string $supplier_phone): self
    {
        $this->supplier_phone = $supplier_phone;

        return $this;
    }

    public function getSupplierEmail(): ?string
    {
        return $this->supplier_email;
    }

    public function setSupplierEmail(?string $supplier_email): self
    {
        $this->supplier_email = $supplier_email;

        return $this;
    }

    public function getSupplierWeb(): ?string
    {
        return $this->supplier_web;
    }

    public function setSupplierWeb(?string $supplier_web): self
    {
        $this->supplier_web = $supplier_web;

        return $this;
    }

    public function getSupplierLogo(): ?string
    {
        return $this->supplier_logo;
    }

    public function setSupplierLogo(?string $supplier_logo): self
    {
        $this->supplier_logo = $supplier_logo;

        return $this;
    }

    public function getSupplierNote(): ?string
    {
        return $this->supplier_note;
    }

    public function setSupplierNote(?string $supplier_note): self
    {
        $this->supplier_note = $supplier_note;

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
            $product->setSupplier($this);
        }

        return $this;
    }

    public function removeProduct(MgProducts $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getSupplier() === $this) {
                $product->setSupplier(null);
            }
        }

        return $this;
    }
}
