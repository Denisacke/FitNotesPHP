<?php

namespace App\Controller;

use App\Entity\DTO\ExerciseMapper;
use App\Entity\DTO\PerformedExerciseDTO;
use App\Entity\DTO\PerformedWorkoutDTO;
use App\Entity\DTO\WorkoutMapper;
use App\Form\PerformedWorkoutType;
use App\Repository\ExerciseRepository;
use App\Repository\PerformedWorkoutRepository;
use App\Service\UserService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\NonUniqueResultException;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PerformedWorkoutController extends AbstractController
{
    private UserService $userService;
    private ExerciseRepository $exerciseRepository;

    private PerformedWorkoutRepository $performedWorkoutRepository;

    /**
     * @param UserService $userService
     * @param ExerciseRepository $exerciseRepository
     * @param PerformedWorkoutRepository $performedWorkoutRepository
     */
    public function __construct(UserService $userService, ExerciseRepository $exerciseRepository, PerformedWorkoutRepository $performedWorkoutRepository)
    {
        $this->userService = $userService;
        $this->exerciseRepository = $exerciseRepository;
        $this->performedWorkoutRepository = $performedWorkoutRepository;
    }


    #[Route('/performed/workout', name: 'app_performed_workout')]
    public function index(): Response
    {
        return $this->render('performed_workout/index.html.twig', [
            'controller_name' => 'PerformedWorkoutController',
        ]);
    }

    /**
     * @throws NonUniqueResultException
     */
    #[Route("/create-performed-workout", name: "create_performed_workout")]
    public function createWorkout(Request $request,
                                  Security $security): Response
    {
        $workout = json_decode($request->request->get('workout'), true);

        $performedWorkout = new PerformedWorkoutDTO();
        if(isset($workout)){
            $performedWorkout->setName($workout['name']);

            $performedExercises = [];
            foreach ($workout['exercises'] as $exercise){
                $performedExercise = new PerformedExerciseDTO();
                $performedExercise->setName($exercise['name']);

                $performedExercises[] = $performedExercise;
            }

            $performedWorkout->setExercises($performedExercises);
        }

        $form = $this->createForm(PerformedWorkoutType::class, $performedWorkout);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $exercises = new ArrayCollection();
            foreach($performedWorkout->getExercises() as $exercise){
                $exercises
                    ->add(ExerciseMapper::mapFromPerformedExerciseDTOToPerformedExercise(
                        $exercise,
                        $performedWorkout,
                        $this->exerciseRepository->findOneByName($exercise->getName()),
                        $this->userService->findUserByName($security->getUser()->getUserIdentifier())
                    )
                );
            }

            $this->performedWorkoutRepository->save(WorkoutMapper::mapFromPerformedWorkoutDTOToPerformedWorkout($performedWorkout, $exercises));
            // You can redirect to another page or return a response as needed
            return $this->redirectToRoute('home_page'); // Change 'index' to the route you want to redirect to
        }

        return $this->render('performed_workout/create_workout.html.twig', [
            'form' => $form->createView(),
        ]);
    }


}
