<?php

namespace App\Service;

use App\Entity\Workout;
use App\Repository\WorkoutRepository;

class WorkoutService
{
    private WorkoutRepository $workoutRepository;

    /**
     * @param WorkoutRepository $workoutRepository
     */
    public function __construct(WorkoutRepository $workoutRepository)
    {
        $this->workoutRepository = $workoutRepository;
    }

    public function saveWorkout(Workout $workout): Workout
    {
        $this->workoutRepository->save($workout);

        return $workout;
    }

    /**
     * @return Workout[]
     */
    public function findAllWorkouts(): array {
        return $this->workoutRepository->findAll();
    }

    public function findAllWorkoutsByUser($user): array {
        return $this->workoutRepository->findAllByUser($user);
    }
    public function findWorkoutById(int $id): Workout
    {
        return $this->workoutRepository->findById($id);
    }

    public function deleteWorkout(int $id): void {
        $this->workoutRepository->deleteById($id);
    }
}