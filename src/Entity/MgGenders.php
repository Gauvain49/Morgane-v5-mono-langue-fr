<?php

namespace App\Entity;

use App\Repository\MgGendersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MgGendersRepository::class)
 */
class MgGenders
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $short_gender;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $name_gender;

    /**
     * @ORM\OneToMany(targetEntity=MgUsers::class, mappedBy="gender")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getShortGender(): ?string
    {
        return $this->short_gender;
    }

    public function setShortGender(string $short_gender): self
    {
        $this->short_gender = $short_gender;

        return $this;
    }

    public function getNameGender(): ?string
    {
        return $this->name_gender;
    }

    public function setNameGender(string $name_gender): self
    {
        $this->name_gender = $name_gender;

        return $this;
    }

    /**
     * @return Collection|MgUsers[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(MgUsers $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setGender($this);
        }

        return $this;
    }

    public function removeUser(MgUsers $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getGender() === $this) {
                $user->setGender(null);
            }
        }

        return $this;
    }
}
