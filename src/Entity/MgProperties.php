<?php

namespace App\Entity;

use App\Repository\MgPropertiesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=MgPropertiesRepository::class)
 */
class MgProperties
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
    private $name;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(type="string", length=100)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity=MgPropertiesValues::class, mappedBy="property", orphanRemoval=true)
     */
    private $propertiesValues;

    /**
     * @ORM\OneToMany(targetEntity=MgProductsProperties::class, mappedBy="property", orphanRemoval=true)
     */
    private $productsProperties;

    public function __construct()
    {
        $this->propertiesValues = new ArrayCollection();
        $this->productsProperties = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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
     * @return Collection|MgPropertiesValues[]
     */
    public function getPropertiesValues(): Collection
    {
        return $this->propertiesValues;
    }

    public function addPropertiesValue(MgPropertiesValues $propertiesValue): self
    {
        if (!$this->propertiesValues->contains($propertiesValue)) {
            $this->propertiesValues[] = $propertiesValue;
            $propertiesValue->setProperty($this);
        }

        return $this;
    }

    public function removePropertiesValue(MgPropertiesValues $propertiesValue): self
    {
        if ($this->propertiesValues->removeElement($propertiesValue)) {
            // set the owning side to null (unless already changed)
            if ($propertiesValue->getProperty() === $this) {
                $propertiesValue->setProperty(null);
            }
        }

        return $this;
    }

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
            $productsProperty->setProperty($this);
        }

        return $this;
    }

    public function removeProductsProperty(MgProductsProperties $productsProperty): self
    {
        if ($this->productsProperties->removeElement($productsProperty)) {
            // set the owning side to null (unless already changed)
            if ($productsProperty->getProperty() === $this) {
                $productsProperty->setProperty(null);
            }
        }

        return $this;
    }

}
