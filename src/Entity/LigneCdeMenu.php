<?php

namespace App\Entity;

use App\Repository\LigneCdeMenuRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LigneCdeMenuRepository")
 */
class LigneCdeMenu extends LigneCde
{
    /**
     * @ORM\ManyToOne(targetEntity=Menu::class, inversedBy="ligneCdeMenus")
     * @ORM\JoinColumn(nullable=false)
     */
    private $menu;

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;

        return $this;
    }
}
