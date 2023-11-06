<?php

namespace App\Controller;

use App\Entity\DTO\BodyPartExerciseDTO;
use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WorkoutController extends AbstractController
{
    private array $bodyParts = ["back", "cardio", "chest", "lower arms", "lower legs", "neck", "shoulders", "upper arms", "upper legs", "waist"];
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'verify' => false
        ]);
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
            $exerciseDTO->setGifUrl($item['gifUrl']);
            // Push the created DTO object to the array
            $exercises[] = $exerciseDTO;
        }
        return $this->render('test.html.twig', ['rightContent' => 'workout/workout_list.html.twig', 'exercises' => $exercises]);
    }
}