<?php

namespace App\Entity\DTO;

class WorkoutDTO
{
    private string $name;

    private array $exercises;

    public function __construct()
    {
        $this->name = '';
    }


    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return BodyPartExerciseDTO[]
     */
    public function getExercises(): array
    {
        return $this->exercises;
    }

    /**
     * @param BodyPartExerciseDTO[] $exercises
     */
    public function setExercises(array $exercises): void
    {
        $this->exercises = $exercises;
    }


}