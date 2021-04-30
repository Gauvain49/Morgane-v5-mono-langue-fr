<?php

namespace App\Entity;

use App\Repository\MgPropertiesValuesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=MgPropertiesValuesRepository::class)
 */
class MgPropertiesValues
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=MgProperties::class, inversedBy="propertiesValues")
     * @ORM\JoinColumn(nullable=false)
     */
    private $property;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $value;

    /**
     * @Gedmo\Slug(fields={"value"})
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity=MgProductsProperties::class, mappedBy="property_value", orphanRemoval=true)
     */
    private $productsProperties;

    public function __construct()
    {
        $this->custom = false;
        $this->productsProperties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /*public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }*/

    /**
     * @return Collection|MgProductsProperties[]
     */
    public function getProductsProperties(): Collection
    {
        return $this->productsProperties;
    }

    public function addProductsProperty(MgProductsProperties $productsProperty): self
    {
        if (!$this->productsProperties->contains($productsProperty)) {
            $this->productsProperties[] = $productsProperty;
            $productsProperty->setPropertyValue($this);
        }

        return $this;
    }

    public function removeProductsProperty(MgProductsProperties $productsProperty): self
    {
        if ($this->productsProperties->removeElement($productsProperty)) {
            // set the owning side to null (unless already changed)
            if ($productsProperty->getPropertyValue() === $this) {
                $productsProperty->setPropertyValue(null);
            }
        }

        return $this;
    }
}
