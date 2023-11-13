<?php

namespace App\Entity;

use App\Repository\UserRepository;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
//#[ORM\Table(name: '`user`')]
//#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    /**
     * @var string The hashed password
     */
    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column]
    private ?int $height = null;

    #[ORM\Column]
    private int $weight;

    #[ORM\Column]
    private int $age;

    #[ORM\Column]
    private int $activityLevel;

    #[ORM\Column(type: "json")]
    private array $roles = ['ROLE_USER'];

    /**
     * @param string|null $username
     * @param string|null $email
     * @param int|null $height
     * @param int $weight
     * @param int $age
     * @param int $activityLevel
     */
    public function __construct(?string $username, ?string $email, ?int $height, int $weight, int $age, int $activityLevel)
    {
        $this->username = $username;
        $this->email = $email;
        $this->height = $height;
        $this->weight = $weight;
        $this->age = $age;
        $this->activityLevel = $activityLevel;
    }

    /**
     * @return int
     */
    public function getWeight(): int
    {
        return $this->weight;
    }

    /**
     * @param int $weight
     */
    public function setWeight(int $weight): void
    {
        $this->weight = $weight;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * @param int $age
     */
    public function setAge(int $age): void
    {
        $this->age = $age;
    }

    /**
     * @return int
     */
    public function getActivityLevel(): int
    {
        return $this->activityLevel;
    }

    /**
     * @param int $activityLevel
     */
    public function setActivityLevel(int $activityLevel): void
    {
        $this->activityLevel = $activityLevel;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setName(string $username): self
    {
        $this->username = $username;

        return $this;
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function setHeight(int $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        $this->password = null;
    }

    public function getUserIdentifier(): string
    {
        return $this->username;
    }
}
