<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CategorieProduitRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CategorieProduitRepository::class)
 * @ApiResource(
 *     normalizationContext={"groups"={"categorieProduit:list"}},
 *     itemOperations={
 *         "get"
 *     },
 *     collectionOperations={
 *         "get"
 *     }
 * )
 */
class CategorieProduit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("categorieProduit:list")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("categorieProduit:list")
     */
    private $nom;

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
}
