<?php

namespace App\Entity;

use App\Repository\MgDepartmentsFrenchRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MgDepartementsFrenchRepository::class)
 */
class MgDepartmentsFrench
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private $code_insee;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=MgRegionsFrench::class, inversedBy="departmentsFrenches")
     * @ORM\JoinColumn(nullable=false)
     */
    private $region;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeInsee(): ?string
    {
        return $this->code_insee;
    }

    public function setCodeInsee(string $code_insee): self
    {
        $this->code_insee = $code_insee;

        return $this;
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

    public function getRegion(): ?MgRegionsFrench
    {
        return $this->region;
    }

    public function setRegion(?MgRegionsFrench $region): self
    {
        $this->region = $region;

        return $this;
    }
}
