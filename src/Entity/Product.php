<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(length: 255)]
    private ?string $illustration = null;

    #[ORM\Column(length: 255)]
    private ?string $subtitle = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\Column(length: 255)]
    private ?string $color = null;

    #[ORM\Column(length: 255)]
    private ?string $style = null;

    #[ORM\ManyToMany(targetEntity: Materials::class, inversedBy: 'products')]
    private Collection $materials;

    #[ORM\Column]
    private ?bool $isBest = null;

    

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: MaterialsOfProduct::class)]
    private Collection $materialsOfProducts;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: Comments::class, orphanRemoval: true)]
    private Collection $comments;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: AuthorizationAvis::class)]
    private Collection $authorizationAvis;

    public function __construct()
    {
        $this->materials = new ArrayCollection();
        $this->materialsOfProducts = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->authorizationAvis = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getName();
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

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getIllustration(): ?string
    {
        return $this->illustration;
    }

    public function setIllustration(string $illustration): self
    {
        $this->illustration = $illustration;

        return $this;
    }

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(string $subtitle): self
    {
        $this->subtitle = $subtitle;

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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getStyle(): ?string
    {
        return $this->style;
    }

    public function setStyle(string $style): self
    {
        $this->style = $style;

        return $this;
    }

    /**
     * @return Collection<int, Materials>
     */
    public function getMaterials(): Collection
    {
        return $this->materials;
    }

    public function addMaterial(Materials $material): self
    {
        if (!$this->materials->contains($material)) {
            $this->materials->add($material);
        }

        return $this;
    }

    public function removeMaterial(Materials $material): self
    {
        $this->materials->removeElement($material);

        return $this;
    }

    public function isIsBest(): ?bool
    {
        return $this->isBest;
    }

    public function setIsBest(bool $isBest): self
    {
        $this->isBest = $isBest;

        return $this;
    }

    
    /**
     * @return Collection<int, MaterialsOfProduct>
     */
    public function getMaterialsOfProducts(): Collection
    {
        return $this->materialsOfProducts;
    }

    public function addMaterialsOfProduct(MaterialsOfProduct $materialsOfProduct): self
    {
        if (!$this->materialsOfProducts->contains($materialsOfProduct)) {
            $this->materialsOfProducts->add($materialsOfProduct);
            $materialsOfProduct->setProduct($this);
        }

        return $this;
    }

    public function removeMaterialsOfProduct(MaterialsOfProduct $materialsOfProduct): self
    {
        if ($this->materialsOfProducts->removeElement($materialsOfProduct)) {
            // set the owning side to null (unless already changed)
            if ($materialsOfProduct->getProduct() === $this) {
                $materialsOfProduct->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comments>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comments $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setProduct($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getProduct() === $this) {
                $comment->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AuthorizationAvis>
     */
    public function getAuthorizationAvis(): Collection
    {
        return $this->authorizationAvis;
    }

    public function addAuthorizationAvi(AuthorizationAvis $authorizationAvi): self
    {
        if (!$this->authorizationAvis->contains($authorizationAvi)) {
            $this->authorizationAvis->add($authorizationAvi);
            $authorizationAvi->setProduct($this);
        }

        return $this;
    }

    public function removeAuthorizationAvi(AuthorizationAvis $authorizationAvi): self
    {
        if ($this->authorizationAvis->removeElement($authorizationAvi)) {
            // set the owning side to null (unless already changed)
            if ($authorizationAvi->getProduct() === $this) {
                $authorizationAvi->setProduct(null);
            }
        }

        return $this;
    }
    
}
