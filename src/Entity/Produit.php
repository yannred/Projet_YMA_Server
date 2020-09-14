<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ProduitRepository::class)
 * @ApiResource(
 *     normalizationContext={"groups"={"produits:list"}},
 *     itemOperations={
 *         "get"
 *     },
 *     collectionOperations={
 *         "get"
 *     }
 * )
 */
class Produit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("produits:list")
     * @Groups("categorieProduit:list")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("produits:list")
     * @Groups("categorieProduit:list")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("produits:list")
     * @Groups("categorieProduit:list")
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     * @Groups("produits:list")
     * @Groups("categorieProduit:list")
     */
    private $prix;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("produits:list")
     * @Groups("categorieProduit:list")
     */
    private $photo;

    /**
     * @ORM\Column(type="boolean")
     * @Groups("produits:list")
     * @Groups("categorieProduit:list")
     */
    private $promo;

    /**
     * @ORM\ManyToMany(targetEntity=Menu::class)
     * @Groups("produits:list")
     */
    private $menu;

    /**
     * @ORM\OneToMany(targetEntity=LigneCdeProduit::class, mappedBy="produit", orphanRemoval=true)
     */
    private $ligneCdeProduits;

    /**
     * @ORM\ManyToOne(targetEntity=CategorieProduit::class, inversedBy="produits")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("produits:list")
     */
    private $categorieProduit;

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
        return $this->categorieProduit;
    }

    public function setCategorieProduit(?CategorieProduit $categorieProduit): self
    {
        $this->categorieProduit = $categorieProduit;

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

    public function removeMenu(Menu $menu): self
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
