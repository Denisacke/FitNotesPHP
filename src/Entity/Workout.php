<?php

namespace App\Entity;

use App\Repository\WorkoutRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WorkoutRepository::class)]
#[ORM\Table(name: '`workout`')]
class Workout
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private string $name = '';

    /**
     * @var Collection
     * @ManyToMany(targetEntity="Exercise::class", inversedBy="workouts")
     * @JoinTable(name="workout_exercise",
     *     joinColumns={@JoinColumn(name="workout_id", referencedColumnName="id", onDelete="CASCADE")},
     *     inverseJoinColumns={@JoinColumn(name="exercise_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     */
    #[ORM\ManyToMany(targetEntity: Exercise::class, inversedBy: "workouts", cascade: ["persist", "remove"], fetch: "EAGER")]
    #[ORM\JoinTable(name: "workout_exercise", joinColumns: ["workout_id"], inverseJoinColumns: ["exercise_id"])]
    private Collection $exercises;

    #[ORM\ManyToOne(targetEntity: AuthenticationUser::class)]
    #[ORM\JoinColumn(name: "user_id", referencedColumnName: "id")]
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

    public function addExercise(Exercise $exercise): void
    {
        $this->exercises->add($exercise);
    }

    public function removeExercise(Exercise $exercise): void
    {
        $this->exercises->removeElement($exercise);
        $exercise->removeWorkout($this);
    }

    /**
     * @return AuthenticationUser|null
     */
    public function getUser(): ?AuthenticationUser
    {
        return $this->user;
    }

    /**
     * @param AuthenticationUser|null $user
     */
    public function setUser(?AuthenticationUser $user): void
    {
        $this->user = $user;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }


    public function __toString(): string
    {
        return $this->name;
    }
}
