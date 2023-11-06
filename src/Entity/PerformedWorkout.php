<?php

namespace App\Entity;

use App\Repository\PerformedWorkoutRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PerformedWorkoutRepository::class)]
class PerformedWorkout
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $performedExercises = [];

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $performedDate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getPerformedExercises(): array
    {
        return $this->performedExercises;
    }

    public function setPerformedExercises(array $performedExercises): static
    {
        $this->performedExercises = $performedExercises;

        return $this;
    }

    public function getPerformedDate(): ?\DateTimeInterface
    {
        return $this->performedDate;
    }

    public function setPerformedDate(\DateTimeInterface $performedDate): static
    {
        $this->performedDate = $performedDate;

        return $this;
    }
}
