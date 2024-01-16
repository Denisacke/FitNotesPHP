<?php

namespace App\Controller;

use App\Entity\DTO\ExerciseMapper;
use App\Repository\PerformedExerciseRepository;
use App\Repository\PerformedWorkoutRepository;
use App\Repository\WorkoutRepository;
use App\Service\UserService;
use App\Service\WorkoutService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProgressController extends AbstractController
{
    private UserService $userService;
    private PerformedWorkoutRepository $performedWorkoutRepository;

    private PerformedExerciseRepository $performedExerciseRepository;

    private WorkoutService $workoutService;

    /**
     * @param PerformedWorkoutRepository $performedWorkoutRepository
     * @param PerformedExerciseRepository $performedExerciseRepository
     * @param UserService $userService
     */
    public function __construct(PerformedWorkoutRepository $performedWorkoutRepository,
                                PerformedExerciseRepository $performedExerciseRepository,
                                UserService $userService,
                                WorkoutService $workoutService)
    {
        $this->performedWorkoutRepository = $performedWorkoutRepository;
        $this->performedExerciseRepository = $performedExerciseRepository;
        $this->userService = $userService;
        $this->workoutService = $workoutService;
    }


    #[Route(path: '/progress', name: 'progress_page')]
    public function renderProgressPage(Security $security): Response{

        $user = $this->userService->findUserByName($security->getUser()->getUserIdentifier());

        $exercises = [];
        $performedExercises = array_map(function($exercise) {
            return ExerciseMapper::mapFromPerformedExerciseToPerformedExerciseDTO($exercise);
        }, $this->performedExerciseRepository->findByUserId($user->getId()));

        foreach ($performedExercises as $performedExercise){
            $exercises[] = $performedExercise->getName();
        }

        $workouts = $this->workoutService->findAllWorkoutsByUser($user);
        return $this->render('test.html.twig',
            [
                'rightContent' => 'progress/progress.html.twig',
                'exercises' => array_unique($exercises),
                'performedExercises' => json_encode($performedExercises),
                'workouts' => $this->performedWorkoutRepository->findAll()
            ]
        );
    }
}