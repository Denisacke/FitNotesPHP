<?php

namespace App\Entity\DTO;

use App\Entity\AuthenticationUser;
use App\Entity\Exercise;
use App\Entity\PerformedExercise;

class ExerciseMapper
{
    public static function mapFromExerciseDTOToExercise(BodyPartExerciseDTO $exerciseDTO): Exercise
    {
        $exercise = new Exercise();
        $exercise->setBodyPart($exerciseDTO->getBodyPart());
        $exercise->setEquipment($exerciseDTO->getEquipment());
        $exercise->setGifUrl($exerciseDTO->getGifUrl());
        $exercise->setName($exerciseDTO->getName());
        $exercise->setTarget($exerciseDTO->getTarget());
        $exercise->setSecondaryMuscles($exerciseDTO->getSecondaryMuscles());
        $exercise->setInstructions($exerciseDTO->getInstructions());

        return $exercise;
    }

    public static function mapFromExerciseToExerciseDTO(Exercise $exercise): BodyPartExerciseDTO
    {
        $exerciseDTO = new BodyPartExerciseDTO();
        $exerciseDTO->setBodyPart($exercise->getBodyPart());
        $exerciseDTO->setEquipment($exercise->getEquipment());
        $exerciseDTO->setGifUrl($exercise->getGifUrl());
        $exerciseDTO->setName($exercise->getName());
        $exerciseDTO->setTarget($exercise->getTarget());
        $exerciseDTO->setSecondaryMuscles($exercise->getSecondaryMuscles());
        $exerciseDTO->setInstructions($exercise->getInstructions());

        return $exerciseDTO;
    }

    public static function mapFromPerformedExerciseDTOToPerformedExercise(
        PerformedExerciseDTO $performedExerciseDTO,
        PerformedWorkoutDTO $performedWorkoutDTO,
        Exercise $exercise,
        AuthenticationUser $authenticationUser
    ): PerformedExercise {
        $performedExercise = new PerformedExercise();
        $performedExercise->setExercise($exercise);
        $performedExercise->setUser($authenticationUser);

        // TODO map WorkoutDTO to Workout
        $performedExercise->setPerformedDate($performedWorkoutDTO->getPerformedDate());
        $performedExercise->setReps($performedExerciseDTO->getReps());
        $performedExercise->setWeight($performedExerciseDTO->getWeight());
        $performedExercise->setSets($performedExerciseDTO->getSets());

        return $performedExercise;
    }
}