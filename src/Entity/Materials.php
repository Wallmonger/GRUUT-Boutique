<?php

namespace App\Entity;

use App\Repository\MaterialsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MaterialsRepository::class)]
class Materials
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\ManyToMany(targetEntity: Product::class, mappedBy: 'materials')]
    private Collection $products;

    

    #[ORM\OneToMany(mappedBy: 'material', targetEntity: MaterialsOfProduct::class)]
    private Collection $materialsOfProducts;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->materialsOfProducts = new ArrayCollection();
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

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->addMaterial($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            $product->removeMaterial($this);
        }

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
            $materialsOfProduct->setMaterial($this);
        }

        return $this;
    }

    public function removeMaterialsOfProduct(MaterialsOfProduct $materialsOfProduct): self
    {
        if ($this->materialsOfProducts->removeElement($materialsOfProduct)) {
            // set the owning side to null (unless already changed)
            if ($materialsOfProduct->getMaterial() === $this) {
                $materialsOfProduct->setMaterial(null);
            }
        }

        return $this;
    }
}
