<?php

namespace App\Entity;

use App\Repository\MgCarriersStepsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MgCarriersStepsRepository::class)
 */
class MgCarriersSteps
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=MgCarriersConfig::class, inversedBy="carriersSteps")
     * @ORM\JoinColumn(nullable=false)
     */
    private $config;

    /**
     * @ORM\Column(type="float")
     */
    private $step_min;

    /**
     * @ORM\Column(type="float")
     */
    private $step_max;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity=MgCarriersAmount::class, mappedBy="carrier_step", orphanRemoval=true)
     */
    private $carrierAmounts;

    public function __construct()
    {
        $this->carrierAmounts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConfig(): ?MgCarriersConfig
    {
        return $this->config;
    }

    public function setConfig(?MgCarriersConfig $config): self
    {
        $this->config = $config;

        return $this;
    }

    public function getStepMin(): ?float
    {
        return $this->step_min;
    }

    public function setStepMin(float $step_min): self
    {
        $this->step_min = $step_min;

        return $this;
    }

    public function getStepMax(): ?float
    {
        return $this->step_max;
    }

    public function setStepMax(float $step_max): self
    {
        $this->step_max = $step_max;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|MgCarriersAmount[]
     */
    public function getCarrierAmounts(): Collection
    {
        return $this->carrierAmounts;
    }

    public function addCarrierAmount(MgCarriersAmount $carrierAmount): self
    {
        if (!$this->carrierAmounts->contains($carrierAmount)) {
            $this->carrierAmounts[] = $carrierAmount;
            $carrierAmount->setCarrierStep($this);
        }

        return $this;
    }

    public function removeCarrierAmount(MgCarriersAmount $carrierAmount): self
    {
        if ($this->carrierAmounts->removeElement($carrierAmount)) {
            // set the owning side to null (unless already changed)
            if ($carrierAmount->getCarrierStep() === $this) {
                $carrierAmount->setCarrierStep(null);
            }
        }

        return $this;
    }
}
