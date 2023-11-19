<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExerciseRepository::class)]
#[ORM\Table(name: '`exercise`')]
class Exercise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(nullable: true)]
    private string $bodyPart;

    #[ORM\Column(nullable: true)]
    private string $equipment;

    #[ORM\Column(nullable: true)]
    private string $gifUrl;

    #[ORM\Column(nullable: true)]
    private string $name;

    #[ORM\Column(nullable: true)]
    private string $target;

    #[ORM\Column(nullable: true)]
    private array $secondaryMuscles;

    #[ORM\Column(nullable: true)]
    private array $instructions;

    #[ORM\Column(nullable: true)]
    private ?int $caloriesBurned = null;

    #[ORM\ManyToMany(targetEntity: Workout::class, mappedBy: "exercises")]
    private array $workouts;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getBodyPart(): string
    {
        return $this->bodyPart;
    }

    /**
     * @param string $bodyPart
     */
    public function setBodyPart(string $bodyPart): void
    {
        $this->bodyPart = $bodyPart;
    }

    /**
     * @return string
     */
    public function getEquipment(): string
    {
        return $this->equipment;
    }

    /**
     * @param string $equipment
     */
    public function setEquipment(string $equipment): void
    {
        $this->equipment = $equipment;
    }

    /**
     * @return string
     */
    public function getGifUrl(): string
    {
        return $this->gifUrl;
    }

    /**
     * @param string $gifUrl
     */
    public function setGifUrl(string $gifUrl): void
    {
        $this->gifUrl = $gifUrl;
    }

    /**
     * @return string
     */
    public function getTarget(): string
    {
        return $this->target;
    }

    /**
     * @param string $target
     */
    public function setTarget(string $target): void
    {
        $this->target = $target;
    }

    /**
     * @return string[]
     */
    public function getSecondaryMuscles(): array
    {
        return $this->secondaryMuscles;
    }

    /**
     * @param string[] $secondaryMuscles
     */
    public function setSecondaryMuscles(array $secondaryMuscles): void
    {
        $this->secondaryMuscles = $secondaryMuscles;
    }

    /**
     * @return string[]
     */
    public function getInstructions(): array
    {
        return $this->instructions;
    }

    /**
     * @param string[] $instructions
     */
    public function setInstructions(array $instructions): void
    {
        $this->instructions = $instructions;
    }

    public function getCaloriesBurned(): ?int
    {
        return $this->caloriesBurned;
    }

    public function setCaloriesBurned(?int $caloriesBurned): static
    {
        $this->caloriesBurned = $caloriesBurned;

        return $this;
    }

    public function getWorkouts(): array
    {
        return $this->workouts;
    }

    public function setWorkouts(array $workouts): void
    {
        $this->workouts = $workouts;
    }


}