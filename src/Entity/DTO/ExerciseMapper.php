<?php

namespace App\Entity\DTO;

use App\Entity\Exercise;

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
}