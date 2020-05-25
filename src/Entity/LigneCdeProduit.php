<?php

namespace App\Entity;

use App\Repository\LigneCdeProduitRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LigneCdeProduitRepository")
 */
class LigneCdeProduit extends LigneCde
{
    /**
     * @ORM\ManyToOne(targetEntity=Produit::class, inversedBy="ligneCdeProduits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $produit;

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }
}
