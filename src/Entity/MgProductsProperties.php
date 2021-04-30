<?php

namespace App\Entity;

use App\Repository\MgProductsPropertiesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MgProductsPropertiesRepository::class)
 */
class MgProductsProperties
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=MgPropertiesValues::class, inversedBy="productsProperties")
     * @ORM\JoinColumn(nullable=true)
     */
    private $property_value;

    /**
     * @ORM\ManyToOne(targetEntity=MgProducts::class, inversedBy="productsProperties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity=MgProperties::class, inversedBy="productsProperties")
     * @ORM\JoinColumn(nullable=false)
     */
    private $property;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $custom;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPropertyValue(): ?MgPropertiesValues
    {
        return $this->property_value;
    }

    public function setPropertyValue(?MgPropertiesValues $property_value): self
    {
        $this->property_value = $property_value;

        return $this;
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

    public function getProperty(): ?MgProperties
    {
        return $this->property;
    }

    public function setProperty(?MgProperties $property): self
    {
        $this->property = $property;

        return $this;
    }

    public function getCustom(): ?string
    {
        return $this->custom;
    }

    public function setCustom(?string $custom): self
    {
        $this->custom = $custom;

        return $this;
    }
}
