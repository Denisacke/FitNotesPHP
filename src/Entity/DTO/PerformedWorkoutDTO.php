<?php

namespace App\Entity\DTO;

use DateTimeInterface;

class PerformedWorkoutDTO
{
    private String $name;
    private \DateTime $performedDate;
    private array $exercises;

    public function __construct()
    {
    }


    /**
     * @return PerformedExerciseDTO[]
     */
    public function getExercises(): array
    {
        return $this->exercises;
    }

    /**
     * @param PerformedExerciseDTO[] $exercises
     */
    public function setExercises(array $exercises): void
    {
        $this->exercises = $exercises;
    }

    public function getPerformedDate(): \DateTime
    {
        return $this->performedDate;
    }

    public function setPerformedDate(\DateTime $performedDate): void
    {
        $this->performedDate = $performedDate;
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
        $workoutMessage = [];
        $workoutMessage[] = $this->name;
        $workoutMessage[] = $this->performedDate->format('Y-m-d H:i:s');

        foreach ($this->exercises as $exercise){
            $workoutMessage[] = $exercise->getName();
        }

        return implode(',', $workoutMessage);
    }


}