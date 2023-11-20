<?php

namespace App\Entity;

use App\Repository\WorkoutRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WorkoutRepository::class)]
#[ORM\Table(name: '`workout`')]
class Workout
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: Exercise::class, inversedBy: "workouts")]
    #[ORM\JoinTable(name: "workout_exercise")]
    private Collection $exercises;

    /**
     * @ORM\ManyToOne(targetEntity=AuthenticationUser::class)
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private ?AuthenticationUser $user;
    
    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }


    /**
     * @return Collection|Exercise[]
     */
    public function getExercises(): Collection
    {
        return $this->exercises;
    }

    /**
     * @param Collection|Exercise[] $exercises
     */
    public function setExercises(Collection $exercises): void
    {
        $this->exercises = $exercises;
    }
}
