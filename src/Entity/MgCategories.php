<?php

namespace App\Entity;

use App\Repository\MgCategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=MgCategoriesRepository::class)
 */
class MgCategories
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\Column(type="boolean")
     */
    private $force_display;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $type;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_creat;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_up;

    /**
     * @ORM\Column(type="smallint")
     */
    private $level;

    /**
     * @ORM\ManyToOne(targetEntity=MgCategories::class, inversedBy="children")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity=MgCategories::class, mappedBy="parent")
     */
    private $children;

    /**
     * @ORM\Column(type="integer")
     */
    private $position;

    /**
     * @ORM\ManyToMany(targetEntity=MgProducts::class, mappedBy="categories")
     */
    private $products;

    /**
     * @ORM\ManyToMany(targetEntity=MgPosts::class, mappedBy="categories")
     */
    private $posts;

    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->date_creat = new \Datetime();
        $this->products = new ArrayCollection();
        $this->posts = new ArrayCollection();
    }

    /*public function __toString()
    {
        return $this->getName();
    }*/

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getForceDisplay(): ?bool
    {
        return $this->force_display;
    }

    public function setForceDisplay(bool $force_display): self
    {
        $this->force_display = $force_display;

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

    public function getDateCreat(): ?\DateTimeInterface
    {
        return $this->date_creat;
    }

    public function setDateCreat(\DateTimeInterface $date_creat): self
    {
        $this->date_creat = $date_creat;

        return $this;
    }

    public function getDateUp(): ?\DateTimeInterface
    {
        return $this->date_up;
    }

    public function setDateUp(?\DateTimeInterface $date_up): self
    {
        $this->date_up = $date_up;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(self $child): self
    {
        if (!$this->children->contains($child)) {
            $this->children[] = $child;
            $child->setParent($this);
        }

        return $this;
    }

    public function removeChild(self $child): self
    {
        if ($this->children->removeElement($child)) {
            // set the owning side to null (unless already changed)
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return Collection|MgProducts[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(MgProducts $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->addCategory($this);
        }

        return $this;
    }

    public function removeProduct(MgProducts $product): self
    {
        if ($this->products->removeElement($product)) {
            $product->removeCategory($this);
        }

        return $this;
    }

    /**
     * @return Collection|MgPosts[]
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(MgPosts $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->addCategory($this);
        }

        return $this;
    }

    public function removePost(MgPosts $post): self
    {
        if ($this->posts->removeElement($post)) {
            $post->removeCategory($this);
        }

        return $this;
    }
}
