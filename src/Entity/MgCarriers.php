<?php

namespace App\Entity;

use App\Repository\MgCarriersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MgCarriersRepository::class)
 */
class MgCarriers
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
    private $carrier_name;

    /**
     * @ORM\Column(type="text")
     */
    private $carrier_description;

    /**
     * @ORM\Column(type="boolean")
     */
    private $carrier_active;

    /**
     * @ORM\Column(type="boolean")
     */
    private $carrier_default;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $carrier_logo;

    /**
     * @ORM\OneToMany(targetEntity=MgProducts::class, mappedBy="carrier")
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

    public function getCarrierName(): ?string
    {
        return $this->carrier_name;
    }

    public function setCarrierName(string $carrier_name): self
    {
        $this->carrier_name = $carrier_name;

        return $this;
    }

    public function getCarrierDescription(): ?string
    {
        return $this->carrier_description;
    }

    public function setCarrierDescription(string $carrier_description): self
    {
        $this->carrier_description = $carrier_description;

        return $this;
    }

    public function getCarrierActive(): ?bool
    {
        return $this->carrier_active;
    }

    public function setCarrierActive(bool $carrier_active): self
    {
        $this->carrier_active = $carrier_active;

        return $this;
    }

    public function getCarrierDefault(): ?bool
    {
        return $this->carrier_default;
    }

    public function setCarrierDefault(bool $carrier_default): self
    {
        $this->carrier_default = $carrier_default;

        return $this;
    }

    public function getCarrierLogo(): ?string
    {
        return $this->carrier_logo;
    }

    public function setCarrierLogo(?string $carrier_logo): self
    {
        $this->carrier_logo = $carrier_logo;

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
            $product->setCarrier($this);
        }

        return $this;
    }

    public function removeProduct(MgProducts $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getCarrier() === $this) {
                $product->setCarrier(null);
            }
        }

        return $this;
    }
}
