<?php

namespace App\Entity;

use App\Repository\MgCarriersConfigRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MgCarriersConfigRepository::class)
 */
class MgCarriersConfig
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=MgCarriers::class, inversedBy="carriersConfigs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $carrier;

    /**
     * @ORM\ManyToOne(targetEntity=MgTaxes::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $taxe;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $billing_on;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $out_of_range;

    /**
     * @ORM\OneToMany(targetEntity=MgCarriersSteps::class, mappedBy="config", orphanRemoval=true)
     */
    private $carriersSteps;

    /**
     * @ORM\OneToMany(targetEntity=MgCarriersAmount::class, mappedBy="carrier_config", orphanRemoval=true)
     */
    private $carriersAmounts;

    public function __construct()
    {
        $this->carriersSteps = new ArrayCollection();
        $this->carriersAmounts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCarrier(): ?MgCarriers
    {
        return $this->carrier;
    }

    public function setCarrier(?MgCarriers $carrier): self
    {
        $this->carrier = $carrier;

        return $this;
    }

    public function getTaxe(): ?MgTaxes
    {
        return $this->taxe;
    }

    public function setTaxe(?MgTaxes $taxe): self
    {
        $this->taxe = $taxe;

        return $this;
    }

    public function getBillingOn(): ?string
    {
        return $this->billing_on;
    }

    public function setBillingOn(string $billing_on): self
    {
        $this->billing_on = $billing_on;

        return $this;
    }

    public function getOutOfRange(): ?string
    {
        return $this->out_of_range;
    }

    public function setOutOfRange(string $out_of_range): self
    {
        $this->out_of_range = $out_of_range;

        return $this;
    }

    /**
     * @return Collection|MgCarriersSteps[]
     */
    public function getCarriersSteps(): Collection
    {
        return $this->carriersSteps;
    }

    public function addCarriersStep(MgCarriersSteps $carriersStep): self
    {
        if (!$this->carriersSteps->contains($carriersStep)) {
            $this->carriersSteps[] = $carriersStep;
            $carriersStep->setConfig($this);
        }

        return $this;
    }

    public function removeCarriersStep(MgCarriersSteps $carriersStep): self
    {
        if ($this->carriersSteps->removeElement($carriersStep)) {
            // set the owning side to null (unless already changed)
            if ($carriersStep->getConfig() === $this) {
                $carriersStep->setConfig(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MgCarriersAmount[]
     */
    public function getCarriersAmounts(): Collection
    {
        return $this->carriersAmounts;
    }

    public function addCarriersAmount(MgCarriersAmount $carriersAmount): self
    {
        if (!$this->carriersAmounts->contains($carriersAmount)) {
            $this->carriersAmounts[] = $carriersAmount;
            $carriersAmount->setCarrierConfig($this);
        }

        return $this;
    }

    public function removeCarriersAmount(MgCarriersAmount $carriersAmount): self
    {
        if ($this->carriersAmounts->removeElement($carriersAmount)) {
            // set the owning side to null (unless already changed)
            if ($carriersAmount->getCarrierConfig() === $this) {
                $carriersAmount->setCarrierConfig(null);
            }
        }

        return $this;
    }
}
