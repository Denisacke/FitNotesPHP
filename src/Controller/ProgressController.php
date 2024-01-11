<?php

namespace App\Controller;

use App\Entity\DTO\ExerciseMapper;
use App\Repository\PerformedExerciseRepository;
use App\Repository\PerformedWorkoutRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProgressController extends AbstractController
{
    private PerformedWorkoutRepository $performedWorkoutRepository;

    private PerformedExerciseRepository $performedExerciseRepository;

    /**
     * @param PerformedWorkoutRepository $performedWorkoutRepository
     * @param PerformedExerciseRepository $performedExerciseRepository
     */
    public function __construct(PerformedWorkoutRepository $performedWorkoutRepository, PerformedExerciseRepository $performedExerciseRepository)
    {
        $this->performedWorkoutRepository = $performedWorkoutRepository;
        $this->performedExerciseRepository = $performedExerciseRepository;
    }


    #[Route(path: '/progress', name: 'progress_page')]
    public function renderProgressPage(): Response{
        $exercises = [];
        $performedExercises = array_map(function($exercise) {
            return ExerciseMapper::mapFromPerformedExerciseToPerformedExerciseDTO($exercise);
        }, $this->performedExerciseRepository->findAll());

        foreach ($performedExercises as $performedExercise){
            $exercises[] = $performedExercise->getName();
        }

        return $this->render('test.html.twig',
            [
                'rightContent' => 'progress/progress.html.twig',
                'exercises' => array_unique($exercises),
                'performedExercises' => json_encode(array_map(function($exercise) {
                    return ExerciseMapper::mapFromPerformedExerciseToPerformedExerciseDTO($exercise);
                }, $this->performedExerciseRepository->findAll())),
                'workouts' => $this->performedWorkoutRepository->findAll()
            ]
        );
    }

    #[Route(path: '/progress/display-exercise-progress')]
    public function computeChartDataForExerciseProgress(Request $request): Response{
        dd($request->request->get('exerciseName'));
    }
}