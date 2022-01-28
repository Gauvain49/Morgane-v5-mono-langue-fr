<?php

namespace App\Entity;

use App\Repository\MgCarriersAmountRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MgCarriersAmountRepository::class)
 */
class MgCarriersAmount
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=MgCarriersSteps::class, inversedBy="carrierAmounts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $carrier_step;

    /**
     * @ORM\Column(type="integer")
     */
    private $place_id;

    /**
     * @ORM\ManyToOne(targetEntity=MgCarriersConfig::class, inversedBy="carriersAmounts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $carrier_config;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $amount;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCarrierStep(): ?MgCarriersSteps
    {
        return $this->carrier_step;
    }

    public function setCarrierStep(?MgCarriersSteps $carrier_step): self
    {
        $this->carrier_step = $carrier_step;

        return $this;
    }

    public function getPlaceId(): ?int
    {
        return $this->place_id;
    }

    public function setPlaceId(int $place_id): self
    {
        $this->place_id = $place_id;

        return $this;
    }

    public function getCarrierConfig(): ?MgCarriersConfig
    {
        return $this->carrier_config;
    }

    public function setCarrierConfig(?MgCarriersConfig $carrier_config): self
    {
        $this->carrier_config = $carrier_config;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(?float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }
}
