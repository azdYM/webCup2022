<?php

namespace App\Entity;

use App\Controller\MeController;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use App\Controller\SignInController;
use ApiPlatform\Core\Annotation\ApiResource;
use DateTimeImmutable;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read:User:collection']],
    collectionOperations: [
        'get' => [
            'controller' => NotFoundAction::class,
            'openapi_context' => ['summary' => 'hidden'],
            'read' => false,
            'output' => false
        ],

        'post' => [
            'denormalization_context' => ['groups' => ['create:User:collection']], 
            'controller' => SignInController::class,
        ]
    ],

    itemOperations: [
        'get' => [
            'controller' => NotFoundAction::class,
            'openapi_context' => ['summary' => 'hidden'],
            'read' => false,
            'output' => false
        ],

        'me' => [
            'path' => '/me',
            'method' => 'get',
            'pagination_enabled' => false,
            'controller' => MeController::class,
            'read' => false,
            'openapi_context' => [
                'security' => [['bearerAuth' => []]]
            ],
            'security' => 'is_granted("ROLE_USER")'
        ],
    ]
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read:User:collection'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['create:User:collection'])]
    private $firstName;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['create:User:collection'])]
    private $secondName;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Groups(['read:User:collection', 'create:User:collection'])]
    private $email;

    #[ORM\Column(type: 'json')]
    #[Groups(['read:User:collection'])]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    #[Groups(['create:User:collection'])]
    private $password;

    #[ORM\Column(type: 'datetime_immutable')]
    private $createdAt;

    #[ORM\Column(type: 'datetime_immutable')]
    private $updatedAt;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Capsule::class)]
    private $capsule;

    public function __construct() {

        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
        $this->capsule = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getSecondName(): ?string
    {
        return $this->secondName;
    }

    public function setSecondName(string $secondName): self
    {
        $this->secondName = $secondName;

        return $this;
    }

    /**
     * @return Collection<int, Capsule>
     */
    public function getCapsule(): Collection
    {
        return $this->capsule;
    }

    public function addCapsule(Capsule $capsule): self
    {
        if (!$this->capsule->contains($capsule)) {
            $this->capsule[] = $capsule;
            $capsule->setUser($this);
        }

        return $this;
    }

    public function removeCapsule(Capsule $capsule): self
    {
        if ($this->capsule->removeElement($capsule)) {
            // set the owning side to null (unless already changed)
            if ($capsule->getUser() === $this) {
                $capsule->setUser(null);
            }
        }

        return $this;
    }
}
