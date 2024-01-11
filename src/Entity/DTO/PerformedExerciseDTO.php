<?php

namespace App\Entity\DTO;

class PerformedExerciseDTO
{
    public string $name;
    public int $reps;
    public int $sets;
    public int $weight;
    public \DateTime $performedDate;

    public function __construct()
    {

    }

    public function getReps(): int
    {
        return $this->reps;
    }

    public function setReps(int $reps): void
    {
        $this->reps = $reps;
    }

    public function getSets(): int
    {
        return $this->sets;
    }

    public function setSets(int $sets): void
    {
        $this->sets = $sets;
    }

    public function getWeight(): int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): void
    {
        $this->weight = $weight;
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
        $performedDateString = $this->performedDate->format('Y-m-d H:i:s');

        return "{$this->name},{$this->reps},{$this->sets},{$this->weight},{$performedDateString}";
    }


}