<?php

namespace App\Entity\DTO;

use App\Entity\PerformedExercise;
use App\Entity\PerformedWorkout;
use App\Entity\Workout;
use Doctrine\Common\Collections\Collection;

class WorkoutMapper
{
    public static function mapFromWorkoutToWorkoutDTO(Workout $workout): WorkoutDTO
    {
        $workoutDTO = new WorkoutDTO();

        $workoutDTO->setId($workout->getId());
        $workoutDTO->setName($workout->getName());
        $workoutDTO->setExercises($workout
            ->getExercises()
            ->map(function($exercise): BodyPartExerciseDTO
                {
                    return ExerciseMapper::mapFromExerciseToExerciseDTO($exercise);
                }
            )
            ->toArray());

        return $workoutDTO;
    }

    public static function mapFromPerformedWorkoutDTOToPerformedWorkout(PerformedWorkoutDTO $performedWorkoutDTO, Collection $performedExercises): PerformedWorkout {
        $performedWorkout = new PerformedWorkout();
        $performedWorkout->setName($performedWorkoutDTO->getName());
        $performedWorkout->setPerformedDate($performedWorkoutDTO->getPerformedDate());
        $mappedExercises = $performedExercises->map(function (PerformedExercise $performedExercise) use ($performedWorkout) {
            $performedExercise->setPerformedWorkout($performedWorkout);
            return $performedExercise;
        });

        $performedWorkout->setPerformedExercises($mappedExercises);

        return $performedWorkout;
    }
}