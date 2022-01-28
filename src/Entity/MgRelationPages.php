<?php

namespace App\Entity;

use App\Repository\MgRelationPagesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MgRelationPagesRepository::class)
 */
class MgRelationPages
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=MgPosts::class, inversedBy="relationPages", cascade={"persist", "remove"})
     */
    private $post;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $relation_file;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPost(): ?MgPosts
    {
        return $this->post;
    }

    public function setPost(?MgPosts $post): self
    {
        $this->post = $post;

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

    public function getRelationFile(): ?string
    {
        return $this->relation_file;
    }

    public function setRelationFile(string $relation_file): self
    {
        $this->relation_file = $relation_file;

        return $this;
    }
}
