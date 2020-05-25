<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProduitRepository::class)
 */
class Produit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo;

    /**
     * @ORM\Column(type="boolean")
     */
    private $promo;

    /**
     * @ORM\ManyToOne(targetEntity=CategorieProduit::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie_produit;

    /**
     * @ORM\ManyToMany(targetEntity=menu::class)
     */
    private $menu;

    /**
     * @ORM\OneToMany(targetEntity=LigneCdeProduit::class, mappedBy="produit", orphanRemoval=true)
     */
    private $ligneCdeProduits;

    public function __construct()
    {
        $this->menu = new ArrayCollection();
        $this->ligneCdeProduits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

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

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getPromo(): ?bool
    {
        return $this->promo;
    }

    public function setPromo(bool $promo): self
    {
        $this->promo = $promo;

        return $this;
    }

    public function getCategorieProduit(): ?CategorieProduit
    {
        return $this->categorie_produit;
    }

    public function setCategorieProduit(?CategorieProduit $categorie_produit): self
    {
        $this->categorie_produit = $categorie_produit;

        return $this;
    }

    /**
     * @return Collection|menu[]
     */
    public function getMenu(): Collection
    {
        return $this->menu;
    }

    public function addMenu(menu $menu): self
    {
        if (!$this->menu->contains($menu)) {
            $this->menu[] = $menu;
        }

        return $this;
    }

    public function removeMenu(menu $menu): self
    {
        if ($this->menu->contains($menu)) {
            $this->menu->removeElement($menu);
        }

        return $this;
    }

    /**
     * @return Collection|LigneCdeProduit[]
     */
    public function getLigneCdeProduits(): Collection
    {
        return $this->ligneCdeProduits;
    }

    public function addLigneCdeProduit(LigneCdeProduit $ligneCdeProduit): self
    {
        if (!$this->ligneCdeProduits->contains($ligneCdeProduit)) {
            $this->ligneCdeProduits[] = $ligneCdeProduit;
            $ligneCdeProduit->setProduit($this);
        }

        return $this;
    }

    public function removeLigneCdeProduit(LigneCdeProduit $ligneCdeProduit): self
    {
        if ($this->ligneCdeProduits->contains($ligneCdeProduit)) {
            $this->ligneCdeProduits->removeElement($ligneCdeProduit);
            // set the owning side to null (unless already changed)
            if ($ligneCdeProduit->getProduit() === $this) {
                $ligneCdeProduit->setProduit(null);
            }
        }

        return $this;
    }
}
