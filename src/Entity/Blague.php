<?php

namespace App\Entity;

use App\Repository\BlagueRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BlagueRepository::class)]
class Blague
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $blague = null;





    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBlague(): ?string
    {
        return $this->blague;
    }

    public function setBlague(string $blague): self
    {
        $this->blague = $blague;

        return $this;
    }

}
