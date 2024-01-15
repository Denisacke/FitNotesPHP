<?php

namespace App\Controller;

use App\Entity\DTO\BodyPartExerciseDTO;
use App\Entity\Exercise;
use App\Entity\Workout;
use App\Repository\AuthenticationUserRepository;
use App\Repository\ExerciseRepository;
use App\Repository\PerformedWorkoutRepository;
use App\Service\WorkoutService;
use Doctrine\Common\Collections\ArrayCollection;
use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WorkoutController extends AbstractController
{
    private array $bodyParts = ["back", "cardio", "chest", "lower arms", "lower legs", "neck", "shoulders", "upper arms", "upper legs", "waist"];
    private array $muscles = ["abductors", "abs", "adductors", "biceps", "calves",
        "cardiovascular system", "delts", "forearms", "glutes", "hamstrings", "lats",
        "levator scapulae", "pectorals", "quads", "serratus anterior", "spine", "traps", "triceps", "upper back"];
    private Client $client;
    private WorkoutService $workoutService;

    private PerformedWorkoutRepository $performedWorkoutRepository;

    private AuthenticationUserRepository $authenticationUserRepository;

    public function __construct(WorkoutService $workoutService,
                                PerformedWorkoutRepository $performedWorkoutRepository,
                                AuthenticationUserRepository $authenticationUserRepository)
    {
        $this->client = new Client([
            'verify' => false
        ]);
        $this->workoutService = $workoutService;
        $this->authenticationUserRepository = $authenticationUserRepository;
        $this->performedWorkoutRepository = $performedWorkoutRepository;
    }

    #[Route(path: '/workout', name: 'workout_page')]
    public function renderWorkouts(LoggerInterface $logger): Response{

        return $this->render('test.html.twig',
            [
                'rightContent' => 'workout/workout_bodypart_list.html.twig',
                'bodyParts' => $this->bodyParts,
                'muscles' => $this->muscles
            ]
        );
    }

    private function buildExerciseArray($responseArray): array {
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

            $exercises[] = $exerciseDTO;
        }

        return $exercises;
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

        return $this->render('test.html.twig', [
            'rightContent' => 'workout/workout_list.html.twig',
            'exercises' => $this->buildExerciseArray($responseArray)
        ]);
    }

    #[Route(path: '/find-exercises-muscle', name: 'find_exercises_by_muscle', methods: "POST")]
    public function renderExercisesByMuscle(Request $request): Response{
        $selectedMuscle = $request->request->get('muscle');

        $response = $this->client->request('GET', 'https://exercisedb.p.rapidapi.com/exercises/target/' . $selectedMuscle . '?limit=10', [
            'headers' => [
                'X-RapidAPI-Host' => 'exercisedb.p.rapidapi.com',
                'X-RapidAPI-Key' => '47daba2431msh4a910d0f3b0f50dp13a2a9jsnd0e012cc6431',
            ],
        ]);

        $responseArray = json_decode($response->getBody(), true);

        return $this->render('test.html.twig', [
            'rightContent' => 'workout/workout_list.html.twig',
            'exercises' => $this->buildExerciseArray($responseArray)
        ]);
    }

    #[Route(path: '/delete-workout/{id}', name: 'delete_workout', methods: "DELETE")]
    public function deleteWorkout(int $id, LoggerInterface $logger): Response{
        $this->workoutService->deleteWorkout($id);
        $logger->info('deleted workout with id' . $id);

        return $this->redirectToRoute('home_page');
    }

    #[Route(path: '/workout-details/{id}', name: 'workout_details')]
    public function renderWorkoutDetails(int $id): Response{

        $workout = $this->workoutService->findWorkoutById($id);

        return $this->render('test.html.twig', [
            'rightContent' => 'workout/workout_details.html.twig',
            'workout' => $workout,
            'performedWorkouts' => json_encode($this->performedWorkoutRepository->findByWorkoutName($workout->getName()))
        ]);
    }
    #[Route(path: '/save-workout', name: 'save_workout', methods: "POST", format: "json")]
    public function saveWorkout(Request $request, LoggerInterface $logger, Security $security): Response{
        $content = $request->getContent();
        $data = json_decode($content, true);

        if (isset($data['selected_exercises']) && isset($data['workout_name'])) {
            $selectedExercises = $data['selected_exercises'];

            $exerciseCollection = new ArrayCollection();
            foreach ($selectedExercises as $selectedExerciseData) {

                $exercise = new Exercise();
                $exercise->setName($selectedExerciseData['name']);
                $exercise->setBodyPart($selectedExerciseData['bodyPart']);
                $exercise->setEquipment($selectedExerciseData['equipment']);
                $exercise->setGifUrl($selectedExerciseData['gifUrl']);
                $exercise->setTarget($selectedExerciseData['target']);
                $exercise->setSecondaryMuscles($selectedExerciseData['secondaryMuscles']);
                $exercise->setInstructions($selectedExerciseData['instructions']);

                // Create a new Exercise entity
                $exerciseCollection->add($exercise);
            }

            $workout = new Workout();
            $workout->setName($data['workout_name']);
            $workout->setExercises($exerciseCollection);
            $workout->setUser($this->authenticationUserRepository->findOneByUsername($security->getUser()->getUserIdentifier()));
            $this->workoutService->saveWorkout($workout);
        } else {
            $logger->error("'selected_exercises' or 'workout_name' not found in JSON data");
            dd('Error! Make sure you have selected exercises and entered a name for the workout');
        }
        return $this->redirectToRoute('home_page');
    }
}