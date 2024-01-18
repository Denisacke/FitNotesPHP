<?php

namespace App\Entity\DTO;

class WorkoutDTO
{
    public int $id;
    public string $name;

    public array $exercises;

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

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }


}