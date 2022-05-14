<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ForfaitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ForfaitRepository::class)]
#[ApiResource(
    collectionOperations: [
        'get' => [
            'normalization_context' => ['groups' => 'read:Forfait:collection']
        ]
    ]
)]
class Forfait
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read:Forfait:collection'])]
    private $id;

    #[ORM\OneToMany(mappedBy: 'forfait', targetEntity: Capsule::class)]
    private $capsules;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->capsules = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Capsule>
     */
    public function getCapsules(): Collection
    {
        return $this->capsules;
    }

    public function addCapsule(Capsule $capsule): self
    {
        if (!$this->capsules->contains($capsule)) {
            $this->capsules[] = $capsule;
            $capsule->setForfait($this);
        }

        return $this;
    }

    public function removeCapsule(Capsule $capsule): self
    {
        if ($this->capsules->removeElement($capsule)) {
            // set the owning side to null (unless already changed)
            if ($capsule->getForfait() === $this) {
                $capsule->setForfait(null);
            }
        }

        return $this;
    }
}
