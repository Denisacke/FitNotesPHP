<?php

namespace App\Entity;

use App\Repository\PerformedWorkoutRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PerformedWorkoutRepository::class)]
#[ORM\Table(name: '`performed_workout`')]
class PerformedWorkout
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private string $name;

    #[ORM\OneToMany(mappedBy: "performedWorkout", targetEntity: PerformedExercise::class, cascade: ["persist"], fetch: "EAGER")]
    #[ORM\JoinTable(name: "performed_workout_performed_exercise")]
    private Collection $performedExercises;

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

    public function getPerformedExercises(): Collection
    {
        return $this->performedExercises;
    }

    public function setPerformedExercises(Collection $performedExercises): static
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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }


}
