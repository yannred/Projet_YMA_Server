<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandeRepository::class)
 */
class Commande
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $emporter;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_retrait;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_liv;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $heure_retrait;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $heure_liv;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $commentaire;

    /**
     * @ORM\Column(type="float")
     */
    private $prix_total;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmporter(): ?bool
    {
        return $this->emporter;
    }

    public function setEmporter(bool $emporter): self
    {
        $this->emporter = $emporter;

        return $this;
    }

    public function getDateRetrait(): ?\DateTimeInterface
    {
        return $this->date_retrait;
    }

    public function setDateRetrait(?\DateTimeInterface $date_retrait): self
    {
        $this->date_retrait = $date_retrait;

        return $this;
    }

    public function getDateLiv(): ?\DateTimeInterface
    {
        return $this->date_liv;
    }

    public function setDateLiv(?\DateTimeInterface $date_liv): self
    {
        $this->date_liv = $date_liv;

        return $this;
    }

    public function getHeureRetrait(): ?\DateTimeInterface
    {
        return $this->heure_retrait;
    }

    public function setHeureRetrait(?\DateTimeInterface $heure_retrait): self
    {
        $this->heure_retrait = $heure_retrait;

        return $this;
    }

    public function getHeureLiv(): ?\DateTimeInterface
    {
        return $this->heure_liv;
    }

    public function setHeureLiv(?\DateTimeInterface $heure_liv): self
    {
        $this->heure_liv = $heure_liv;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getPrixTotal(): ?float
    {
        return $this->prix_total;
    }

    public function setPrixTotal(float $prix_total): self
    {
        $this->prix_total = $prix_total;

        return $this;
    }
}
