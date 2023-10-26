<?php

namespace App\Entity;

use App\Repository\AuthorizationAvisRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuthorizationAvisRepository::class)]
class AuthorizationAvis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'authorizationAvis')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'authorizationAvis')]
    private ?Product $product = null;

    #[ORM\Column]
    private ?bool $IsAllowed = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function isIsAllowed(): ?bool
    {
        return $this->IsAllowed;
    }

    public function setIsAllowed(bool $IsAllowed): self
    {
        $this->IsAllowed = $IsAllowed;

        return $this;
    }
}
