<?php

namespace App\Entity;

use App\Repository\MgProductsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=MgProductsRepository::class)
 */
class MgProducts
{
    //ENUM de la colonne discount_type
    const DISCOUNT_ON_AMOUNT = 'amount';
    const DISCOUNT_ON_PERCENT = 'percent';

    //ENUM de la colonne type
    const TYPE_MASTER = 'master';
    const TYPE_DOWNLOADABLE = 'downloadable';
    const TYPE_DOWNLOADABLE_EXCLU = 'downloadable_exclu';
    const TYPE_ATTRIBUT = 'attribut';

    private $discountTypeValues = array(
        self::DISCOUNT_ON_AMOUNT, self::DISCOUNT_ON_PERCENT
    );
    private $typeValues = array(
        self::TYPE_MASTER, self::TYPE_DOWNLOADABLE, self::TYPE_DOWNLOADABLE_EXCLU, self::TYPE_ATTRIBUT
    );

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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $summary;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity=MgSuppliers::class, inversedBy="products")
     */
    private $supplier;

    /**
     * @ORM\ManyToOne(targetEntity=MgCarriers::class, inversedBy="products")
     */
    private $carrier;

    /**
     * @ORM\ManyToOne(targetEntity=MgTaxes::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $taxe;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $reference;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $purshasing_price;

    /**
     * @ORM\Column(type="float")
     */
    private $selling_price;

    /**
     * @ORM\Column(type="float")
     */
    private $selling_price_all_taxes;

    /**
     * @ORM\Column(type="integer")
     */
    private $sales_unit;

    /**
     * @ORM\Column(type="integer")
     */
    private $min_quantity;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $max_quantity;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $bulk_quantity;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $discount;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $discount_type;

    /**
     * @ORM\Column(type="boolean", options={"default": false}, nullable=true)
     */
    private $discount_on_taxe;

    /**
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private $stock_management;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $stock_quantity;

    /**
     * @ORM\Column(type="boolean", options={"default": false}, nullable=true)
     */
    private $sell_out_of_stock;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $stock_alert;

    /**
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private $pre_order;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_available;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_publish;

    /**
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private $offline;

    /**
     * @ORM\Column(type="string", length=50)
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
     * @ORM\Column(type="float", nullable=true)
     */
    private $additionnal_shipping_cost;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $width;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $height;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $depth;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $weight;

    /**
     * @ORM\OneToMany(targetEntity=MgProducts::class, mappedBy="parent")
     */
    private $declinaisons;

    /**
     * @ORM\ManyToOne(targetEntity=MgProducts::class, inversedBy="declinaisons")
     */
    private $parent;

    /**
     * @ORM\ManyToMany(targetEntity=MgCategories::class, inversedBy="products")
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity=MgProductsImages::class, mappedBy="product")
     */
    private $images;

    /**
     * @ORM\OneToMany(targetEntity=MgMovementsStocks::class, mappedBy="product", orphanRemoval=true)
     */
    private $movementsStocks;

    /**
     * @ORM\OneToMany(targetEntity=MgProductsNumericals::class, mappedBy="product", orphanRemoval=true)
     */
    private $productsNumericals;

    /**
     * @ORM\OneToMany(targetEntity=MgProductsProperties::class, mappedBy="product", orphanRemoval=true)
     */
    private $productsProperties;

    /**
     * @ORM\ManyToOne(targetEntity=MgManufacturers::class, inversedBy="products")
     */
    private $manufacturer;

    public function __construct()
    {
        $this->date_creat = new \Datetime();
        $this->date_available = new \Datetime();
        $this->date_publish = new \Datetime();
        $this->type = self::TYPE_MASTER;
        $this->declinaisons = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->movementsStocks = new ArrayCollection();
        $this->productsNumericals = new ArrayCollection();
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

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(?string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
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

    public function getSupplier(): ?MgSuppliers
    {
        return $this->supplier;
    }

    public function setSupplier(?MgSuppliers $supplier): self
    {
        $this->supplier = $supplier;

        return $this;
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

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getPurshasingPrice(): ?float
    {
        return $this->purshasing_price;
    }

    public function setPurshasingPrice(?float $purshasing_price): self
    {
        $this->purshasing_price = $purshasing_price;

        return $this;
    }

    public function getSellingPrice(): ?float
    {
        return $this->selling_price;
    }

    public function setSellingPrice(float $selling_price): self
    {
        $this->selling_price = $selling_price;

        return $this;
    }

    public function getSellingPriceAllTaxes(): ?float
    {
        return $this->selling_price_all_taxes;
    }

    public function setSellingPriceAllTaxes(float $selling_price_all_taxes): self
    {
        $this->selling_price_all_taxes = $selling_price_all_taxes;

        return $this;
    }

    public function getSalesUnit(): ?int
    {
        return $this->sales_unit;
    }

    public function setSalesUnit(int $sales_unit): self
    {
        $this->sales_unit = $sales_unit;

        return $this;
    }

    public function getMinQuantity(): ?int
    {
        return $this->min_quantity;
    }

    public function setMinQuantity(int $min_quantity): self
    {
        $this->min_quantity = $min_quantity;

        return $this;
    }

    public function getMaxQuantity(): ?int
    {
        return $this->max_quantity;
    }

    public function setMaxQuantity(?int $max_quantity): self
    {
        $this->max_quantity = $max_quantity;

        return $this;
    }

    public function getBulkQuantity(): ?int
    {
        return $this->bulk_quantity;
    }

    public function setBulkQuantity(?int $bulk_quantity): self
    {
        $this->bulk_quantity = $bulk_quantity;

        return $this;
    }

    public function getDiscount(): ?float
    {
        return $this->discount;
    }

    public function setDiscount(?float $discount): self
    {
        if (!in_array($discount_type, $this->discountTypeValues)) {
            throw new \InvalidArgumentException(
                sprintf('Valeur invalide pour mg_products.discount_type : %s.', $discount_type)
            );
        }
        $this->discount = $discount;

        return $this;
    }

    public function getDiscountType(): ?string
    {
        return $this->discount_type;
    }

    public function setDiscountType(?string $discount_type): self
    {
        $this->discount_type = $discount_type;

        return $this;
    }

    public function getDiscountOnTaxe(): ?bool
    {
        return $this->discount_on_taxe;
    }

    public function setDiscountOnTaxe(?bool $discount_on_taxe): self
    {
        $this->discount_on_taxe = $discount_on_taxe;

        return $this;
    }

    public function getStockManagement(): ?bool
    {
        return $this->stock_management;
    }

    public function setStockManagement(bool $stock_management): self
    {
        $this->stock_management = $stock_management;

        return $this;
    }

    public function getStockQuantity(): ?int
    {
        return $this->stock_quantity;
    }

    public function setStockQuantity(?int $stock_quantity): self
    {
        $this->stock_quantity = $stock_quantity;

        return $this;
    }

    public function getSellOutOfStock(): ?bool
    {
        return $this->sell_out_of_stock;
    }

    public function setSellOutOfStock(?int $sell_out_of_stock): self
    {
        $this->sell_out_of_stock = $sell_out_of_stock;

        return $this;
    }

    public function getStockAlert(): ?int
    {
        return $this->stock_alert;
    }

    public function setStockAlert(?int $stock_alert): self
    {
        $this->stock_alert = $stock_alert;

        return $this;
    }

    public function getPreOrder(): ?bool
    {
        return $this->pre_order;
    }

    public function setPreOrder(bool $pre_order): self
    {
        $this->pre_order = $pre_order;

        return $this;
    }

    public function getDateAvailable(): ?\DateTimeInterface
    {
        return $this->date_available;
    }

    public function setDateAvailable(\DateTimeInterface $date_available): self
    {
        $this->date_available = $date_available;

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

    public function getOffline(): ?bool
    {
        return $this->offline;
    }

    public function setOffline(bool $offline): self
    {
        $this->offline = $offline;

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
                sprintf('Valeur invalide pour mg_products.type : %s.', $type)
            );
        }
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

    public function getAdditionnalShippingCost(): ?float
    {
        return $this->additionnal_shipping_cost;
    }

    public function setAdditionnalShippingCost(float $additionnal_shipping_cost): self
    {
        $this->additionnal_shipping_cost = $additionnal_shipping_cost;

        return $this;
    }

    public function getWidth(): ?float
    {
        return $this->width;
    }

    public function setWidth(?float $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight(): ?float
    {
        return $this->height;
    }

    public function setHeight(?float $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getDepth(): ?float
    {
        return $this->depth;
    }

    public function setDepth(?float $depth): self
    {
        $this->depth = $depth;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(?float $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getDeclinaisons(): ?self
    {
        return $this->declinaisons;
    }

    public function addDeclinaison(self $declinaison): self
    {
        if (!$this->declinaisons->contains($declinaison)) {
            $this->declinaisons[] = $declinaison;
            $declinaison->setParent($this);
        }

        return $this;
    }

    public function removeDeclinaison(self $declinaison): self
    {
        if ($this->declinaisons->contains($declinaison)) {
            $this->declinaisons->removeElement($declinaison);
            // set the owning side to null (unless already changed)
            if ($declinaison->getParent() === $this) {
                $declinaison->setParent(null);
            }
        }

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

    /**
     * @return Collection|MgProductsImages[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(MgProductsImages $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setProduct($this);
        }

        return $this;
    }

    public function removeImage(MgProductsImages $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getProduct() === $this) {
                $image->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MgMovementsStocks[]
     */
    public function getMovementsStocks(): Collection
    {
        return $this->movementsStocks;
    }

    public function addMovementsStock(MgMovementsStocks $movementsStock): self
    {
        if (!$this->movementsStocks->contains($movementsStock)) {
            $this->movementsStocks[] = $movementsStock;
            $movementsStock->setProduct($this);
        }

        return $this;
    }

    public function removeMovementsStock(MgMovementsStocks $movementsStock): self
    {
        if ($this->movementsStocks->removeElement($movementsStock)) {
            // set the owning side to null (unless already changed)
            if ($movementsStock->getProduct() === $this) {
                $movementsStock->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MgProductsNumericals[]
     */
    public function getProductsNumericals(): Collection
    {
        return $this->productsNumericals;
    }

    public function addProductsNumerical(MgProductsNumericals $productsNumerical): self
    {
        if (!$this->productsNumericals->contains($productsNumerical)) {
            $this->productsNumericals[] = $productsNumerical;
            $productsNumerical->setProduct($this);
        }

        return $this;
    }

    public function removeProductsNumerical(MgProductsNumericals $productsNumerical): self
    {
        if ($this->productsNumericals->removeElement($productsNumerical)) {
            // set the owning side to null (unless already changed)
            if ($productsNumerical->getProduct() === $this) {
                $productsNumerical->setProduct(null);
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
            $productsProperty->setProduct($this);
        }

        return $this;
    }

    public function removeProductsProperty(MgProductsProperties $productsProperty): self
    {
        if ($this->productsProperties->removeElement($productsProperty)) {
            // set the owning side to null (unless already changed)
            if ($productsProperty->getProduct() === $this) {
                $productsProperty->setProduct(null);
            }
        }

        return $this;
    }

    public function getManufacturer(): ?MgManufacturers
    {
        return $this->manufacturer;
    }

    public function setManufacturer(?MgManufacturers $manufacturer): self
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }
}
