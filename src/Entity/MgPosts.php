<?php

namespace App\Entity;

use App\Repository\MgPostsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=MgPostsRepository::class)
 * @ORM\Table(name="mg_posts", indexes={@ORM\Index(columns={"title", "content"}, flags={"fulltext"})})
 */
class MgPosts
{
    //ENUM de la colonne status
    const PUBLISH = 'publish';
    const DRAFT = 'draft';
    const WAIT = 'wait';
    const TRASH = 'trash';
    const BACKUP = 'backup';

    //ENUM de la colonne type
    const PAGE = 'page';
    const POST = 'post';
    const ATTACHMENT = 'attachment';
    const REVISION = 'revision';

    private $statusValues = array(
        self::PUBLISH, self::DRAFT, self::WAIT, self::TRASH, self::BACKUP
    );
    private $typeValues = array(
        self::PAGE, self::POST, self::ATTACHMENT, self::REVISION
    );

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=MgCategories::class, inversedBy="posts")
     */
    private $categories;

    /**
     * @ORM\ManyToOne(targetEntity=MgUsers::class, inversedBy="posts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $status;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $sort;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $mime_type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $media_sizes;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $filename;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $illustration;

    /**
     * @ORM\ManyToOne(targetEntity=MgPosts::class, inversedBy="children")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity=MgPosts::class, mappedBy="parent")
     */
    private $children;

    /**
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private $comment;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_creat;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_update;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_publish;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_expire;

    /**
     * @ORM\OneToOne(targetEntity=MgRelationPages::class, mappedBy="post", cascade={"persist", "remove"})
     */
    private $relationPages;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->children = new ArrayCollection();
        $this->date_creat = new \DateTime();
        $this->date_publish = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|MgCategories[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(MgCategories $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(MgCategories $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    public function getAuthor(): ?MgUsers
    {
        return $this->author;
    }

    public function setAuthor(?MgUsers $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        if (!in_array($type, $this->typeValues)) {
            throw new \InvalidArgumentException(
                sprintf('Valeur invalide pour mg_posts.type : %s.', $type)
            );
        }
        $this->type = $type;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        if (!in_array($status, $this->statusValues)) {
            throw new \InvalidArgumentException(
                sprintf('Valeur invalide pour mg_posts.status : %s.', $status)
            );
        }
        $this->status = $status;

        return $this;
    }

    public function getSort(): ?int
    {
        return $this->sort;
    }

    public function setSort(?int $sort): self
    {
        $this->sort = $sort;

        return $this;
    }

    public function getMimeType(): ?string
    {
        return $this->mime_type;
    }

    public function setMimeType(?string $mime_type): self
    {
        $this->mime_type = $mime_type;

        return $this;
    }

    public function getMediaSizes(): ?string
    {
        return $this->media_sizes;
    }

    public function setMediaSizes(?string $media_sizes): self
    {
        $this->media_sizes = $media_sizes;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(?string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getIllustration(): ?string
    {
        return $this->illustration;
    }

    public function setIllustration(?string $illustration): self
    {
        $this->illustration = $illustration;

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

    public function getComment(): ?bool
    {
        return $this->comment;
    }

    public function setComment(bool $comment): self
    {
        $this->comment = $comment;

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

    public function getDateUpdate(): ?\DateTimeInterface
    {
        return $this->date_update;
    }

    public function setDateUpdate(?\DateTimeInterface $date_update): self
    {
        $this->date_update = $date_update;

        return $this;
    }

    public function getDatePublish(): ?\DateTimeInterface
    {
        return $this->date_publish;
    }

    public function setDatePublish(\DateTimeInterface $date_publish): self
    {
        $this->date_publish = $date_publish;

        return $this;
    }

    public function getDateExpire(): ?\DateTimeInterface
    {
        return $this->date_expire;
    }

    public function setDateExpire(?\DateTimeInterface $date_expire): self
    {
        $this->date_expire = $date_expire;

        return $this;
    }

    public function getRelationPages(): ?MgRelationPages
    {
        return $this->relationPages;
    }

    public function setRelationPages(?MgRelationPages $relationPages): self
    {
        // unset the owning side of the relation if necessary
        if ($relationPages === null && $this->relationPages !== null) {
            $this->relationPages->setPost(null);
        }

        // set the owning side of the relation if necessary
        if ($relationPages !== null && $relationPages->getPost() !== $this) {
            $relationPages->setPost($this);
        }

        $this->relationPages = $relationPages;

        return $this;
    }
}
