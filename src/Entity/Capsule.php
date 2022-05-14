<?php

namespace App\Entity;

use App\Repository\CapsuleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CapsuleRepository::class)]
class Capsule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Forfait::class, inversedBy: 'capsules')]
    private $forfait;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'capsule')]
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getForfait(): ?Forfait
    {
        return $this->forfait;
    }

    public function setForfait(?Forfait $forfait): self
    {
        $this->forfait = $forfait;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
