<?php

namespace App\Controller;

use App\Repository\PerformedWorkoutRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProgressController extends AbstractController
{
    private PerformedWorkoutRepository $performedWorkoutRepository;

    /**
     * @param PerformedWorkoutRepository $performedWorkoutRepository
     */
    public function __construct(PerformedWorkoutRepository $performedWorkoutRepository)
    {
        $this->performedWorkoutRepository = $performedWorkoutRepository;
    }


    #[Route(path: '/progress', name: 'progress_page')]
    public function renderProgressPage(): Response{
        return $this->render('test.html.twig',
            [
                'rightContent' => 'progress/progress.html.twig',
                'workouts' => $this->performedWorkoutRepository->findAll()
            ]
        );
    }
}