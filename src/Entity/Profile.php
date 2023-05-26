<?php

namespace App\Entity;

use App\Repository\ProfileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfileRepository::class)]
class Profile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'profile', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $ofUser = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $username = null;

    #[ORM\OneToMany(mappedBy: 'profile', targetEntity: Blague::class)]
    private Collection $blagues;

    public function __construct()
    {
        $this->blagues = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOfUser(): ?User
    {
        return $this->ofUser;
    }

    public function setOfUser(User $ofUser): self
    {
        $this->ofUser = $ofUser;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return Collection<int, Blague>
     */
    public function getBlagues(): Collection
    {
        return $this->blagues;
    }

    public function addBlague(Blague $blague): self
    {
        if (!$this->blagues->contains($blague)) {
            $this->blagues->add($blague);
            $blague->setProfile($this);
        }

        return $this;
    }

    public function removeBlague(Blague $blague): self
    {
        if ($this->blagues->removeElement($blague)) {
            // set the owning side to null (unless already changed)
            if ($blague->getProfile() === $this) {
                $blague->setProfile(null);
            }
        }

        return $this;
    }


}
