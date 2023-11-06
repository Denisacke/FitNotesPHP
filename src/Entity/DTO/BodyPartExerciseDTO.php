<?php

namespace App\Entity\DTO;

class BodyPartExerciseDTO
{
    private int $id;

    private string $bodyPart;

    private string $equipment;

    private string $gifUrl;

    private string $name;

    private string $target;

    private array $secondaryMuscles;

    private array $instructions;

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
}