<?php

namespace App\Controller;

use App\Entity\Workout;
use App\Form\WorkoutType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PerformedWorkoutController extends AbstractController
{
    #[Route('/performed/workout', name: 'app_performed_workout')]
    public function index(): Response
    {
        return $this->render('performed_workout/index.html.twig', [
            'controller_name' => 'PerformedWorkoutController',
        ]);
    }

    #[Route("/create-performed-workout", name: "create__performed_workout")]
    public function createWorkout(Request $request): Response
    {
        $workout = new Workout();

        $form = $this->createForm(WorkoutType::class, $workout);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Perform any additional actions upon form submission, e.g., saving to the database
            // For example:
            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($workout);
            // $entityManager->flush();

            // You can redirect to another page or return a response as needed
            return $this->redirectToRoute('index'); // Change 'index' to the route you want to redirect to
        }

        return $this->render('workout/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
