<?php

namespace App\Entity;

use App\Repository\LigneCdeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LigneCdeRepository")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({
 *   "menu" = "LigneCdeMenu",
 *   "produit" = "LigneCdeProduit"
 * })
 */
abstract class LigneCde
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $num_ligne;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantite;

    /**
     * @ORM\ManyToOne(targetEntity=Commande::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $commande;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumLigne(): ?int
    {
        return $this->num_ligne;
    }

    public function setNumLigne(int $num_ligne): self
    {
        $this->num_ligne = $num_ligne;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }
}
