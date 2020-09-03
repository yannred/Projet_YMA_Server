<?php

namespace App\Entity;

use App\Repository\MenuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MenuRepository::class)
 */
class Menu
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
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\Column(type="boolean")
     */
    private $promo;

    /**
     * @ORM\OneToMany(targetEntity=LigneCdeMenu::class, mappedBy="menu", orphanRemoval=true)
     */
    private $ligneCdeMenus;

    public function __construct()
    {
        $this->ligneCdeMenus = new ArrayCollection();
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

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

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

    /**
     * @return Collection|LigneCdeMenu[]
     */
    public function getLigneCdeMenus(): Collection
    {
        return $this->ligneCdeMenus;
    }

    public function addLigneCdeMenu(LigneCdeMenu $ligneCdeMenu): self
    {
        if (!$this->ligneCdeMenus->contains($ligneCdeMenu)) {
            $this->ligneCdeMenus[] = $ligneCdeMenu;
            $ligneCdeMenu->setMenu($this);
        }

        return $this;
    }

    public function removeLigneCdeMenu(LigneCdeMenu $ligneCdeMenu): self
    {
        if ($this->ligneCdeMenus->contains($ligneCdeMenu)) {
            $this->ligneCdeMenus->removeElement($ligneCdeMenu);
            // set the owning side to null (unless already changed)
            if ($ligneCdeMenu->getMenu() === $this) {
                $ligneCdeMenu->setMenu(null);
            }
        }

        return $this;
    }
}
