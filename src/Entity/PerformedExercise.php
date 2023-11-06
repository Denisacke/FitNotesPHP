<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="performed_exercises")
 */
class PerformedExercise
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity="Client")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id")
     */
    private User $client;

    /**
     * @ORM\ManyToOne(targetEntity="Exercise")
     * @ORM\JoinColumn(name="exercise_id", referencedColumnName="id")
     */
    private Exercise $exercise;

    /**
     * @ORM\Column(type="integer")
     */
    private int $reps;

    /**
     * @ORM\Column(type="integer")
     */
    private int $sets;

    /**
     * @ORM\Column(type="float")
     */
    private int $weight;

    /**
     * @ORM\Column(type="date")
     */
    private \DateTime $performedDate;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @return \DateTime
     */
    public function getPerformedDate(): \DateTime
    {
        return $this->performedDate;
    }

    /**
     * @param \DateTime $performedDate
     */
    public function setPerformedDate(\DateTime $performedDate): void
    {
        $this->performedDate = $performedDate;
    }

    /**
     * @param mixed $client
     */
    public function setClient($client): void
    {
        $this->client = $client;
    }

    /**
     * @return mixed
     */
    public function getExercise()
    {
        return $this->exercise;
    }

    /**
     * @param mixed $exercise
     */
    public function setExercise($exercise): void
    {
        $this->exercise = $exercise;
    }

    /**
     * @return mixed
     */
    public function getReps()
    {
        return $this->reps;
    }

    /**
     * @param mixed $reps
     */
    public function setReps($reps): void
    {
        $this->reps = $reps;
    }

    /**
     * @return mixed
     */
    public function getSets()
    {
        return $this->sets;
    }

    /**
     * @param mixed $sets
     */
    public function setSets($sets): void
    {
        $this->sets = $sets;
    }

    /**
     * @return mixed
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param mixed $weight
     */
    public function setWeight($weight): void
    {
        $this->weight = $weight;
    }


}