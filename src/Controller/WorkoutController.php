<?php

namespace App\Controller;

use App\Entity\DTO\BodyPartExerciseDTO;
use App\Entity\DTO\ExerciseMapper;
use App\Entity\Workout;
use App\Form\WorkoutType;
use App\Repository\ExerciseRepository;
use App\Repository\WorkoutRepository;
use Doctrine\Common\Collections\ArrayCollection;
use GuzzleHttp\Client;
use JetBrains\PhpStorm\NoReturn;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WorkoutController extends AbstractController
{
    private array $bodyParts = ["back", "cardio", "chest", "lower arms", "lower legs", "neck", "shoulders", "upper arms", "upper legs", "waist"];
    private Client $client;
    private WorkoutRepository $workoutRepository;
    private ExerciseRepository $exerciseRepository;

    public function __construct(WorkoutRepository $workoutRepository, ExerciseRepository $exerciseRepository)
    {
        $this->client = new Client([
            'verify' => false
        ]);
        $this->workoutRepository = $workoutRepository;
        $this->exerciseRepository = $exerciseRepository;
    }

    #[Route(path: '/workout', name: 'workout_page')]
    public function renderWorkouts(LoggerInterface $logger): Response{

        return $this->render('test.html.twig', ['rightContent' => 'workout/workout_bodypart_list.html.twig', 'bodyParts' => $this->bodyParts]);
    }

    #[Route(path: '/find-exercises-bodypart', name: 'find_exercises_by_bodypart', methods: "POST")]
    public function renderExercisesByBodyPart(Request $request): Response{
        $selectedBodyPart = $request->request->get('bodyPart');

        $response = $this->client->request('GET', 'https://exercisedb.p.rapidapi.com/exercises/bodyPart/' . $selectedBodyPart . '?limit=10', [
            'headers' => [
                'X-RapidAPI-Host' => 'exercisedb.p.rapidapi.com',
                'X-RapidAPI-Key' => '47daba2431msh4a910d0f3b0f50dp13a2a9jsnd0e012cc6431',
            ],
        ]);

        $responseArray = json_decode($response->getBody(), true);

        $exercises = [];
        foreach ($responseArray as $item) {
            $exerciseDTO = new BodyPartExerciseDTO();
            $exerciseDTO->setId($item['id']);
            $exerciseDTO->setBodyPart($item['bodyPart']);
            $exerciseDTO->setName($item['name']);
            $exerciseDTO->setTarget($item['target']);
            $exerciseDTO->setSecondaryMuscles($item['secondaryMuscles']);
            $exerciseDTO->setEquipment($item['equipment']);
            $exerciseDTO->setInstructions($item['instructions']);
            $exerciseDTO->setGifUrl($item['gifUrl']);

//            $this->exerciseRepository->save(ExerciseMapper::mapFromExerciseDTOToExercise($exerciseDTO));
            $exercises[] = $exerciseDTO;
        }

        $workout = new Workout();
        $form = $this->createForm(WorkoutType::class, $workout);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            return $this->redirectToRoute('home_page');
        }

        return $this->render('test.html.twig', [
            'rightContent' => 'workout/workout_list.html.twig',
            'form' => $form->createView(),
            'exercises' => $exercises
        ]);
    }

    #[NoReturn]
    #[Route(path: '/save-workout', name: 'save_workout', methods: "POST")]
    public function saveWorkout(Request $request, LoggerInterface $logger): void{
        $selectedExercises = $request->request->all()['selected_exercises'];
        $workout = new Workout();
        $exerciseCollection = new ArrayCollection();
        foreach ($selectedExercises as $exerciseName) {
            $exercise = $this->exerciseRepository->findOneBy(['name' => $exerciseName]);

            // Check if exercise with the given name was found
            if ($exercise) {
                $exerciseCollection->add($exercise);
            } else {
                $logger->error("Exercise not found!");
                // Handle the case where the exercise with the given name was not found
                // You might want to log an error or handle it based on your application's logic
            }
        }
        $workout->setExercises($exerciseCollection);

//        dd($workout);
        $this->workoutRepository->save($workout);
    }
}