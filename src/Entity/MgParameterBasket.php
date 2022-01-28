<?php

namespace App\Entity;

use App\Repository\MgParameterBasketRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MgParameterBasketRepository::class)
 */
class MgParameterBasket
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $qty_min_cart;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $amount_min_cart;

    /**
     * @ORM\Column(type="boolean")
     */
    private $majority_required;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQtyMinCart(): ?int
    {
        return $this->qty_min_cart;
    }

    public function setQtyMinCart(?int $qty_min_cart): self
    {
        $this->qty_min_cart = $qty_min_cart;

        return $this;
    }

    public function getAmountMinCart(): ?float
    {
        return $this->amount_min_cart;
    }

    public function setAmountMinCart(?float $amount_min_cart): self
    {
        $this->amount_min_cart = $amount_min_cart;

        return $this;
    }

    public function getMajorityRequired(): ?bool
    {
        return $this->majority_required;
    }

    public function setMajorityRequired(bool $majority_required): self
    {
        $this->majority_required = $majority_required;

        return $this;
    }
}
