<?php

namespace App\Entity;

use App\Repository\PerformedExerciseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PerformedExerciseRepository::class)]
#[ORM\Table(name: '`performed_exercise`')]
class PerformedExercise
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\ManyToOne(targetEntity="AuthenticatedUser")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private AuthenticationUser $user;

    /**
     * @ORM\ManyToOne(targetEntity="Exercise")
     * @ORM\JoinColumn(name="exercise_id", referencedColumnName="id")
     */
    private Exercise $exercise;

    /**
     * @ORM\ManyToOne(targetEntity=PerformedWorkout::class, inversedBy="performedExercises")
     * @ORM\JoinColumn(name="performed_workout_id", referencedColumnName="id")
     */
    private PerformedWorkout $performedWorkout;

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
    public function getUser()
    {
        return $this->user;
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
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
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