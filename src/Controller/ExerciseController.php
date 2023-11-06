<?php

namespace App\Controller;

use App\Entity\DTO\BodyPartExerciseDTO;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExerciseController extends AbstractController
{
    /**
     * @throws \Exception
     * @throws GuzzleException
     */
    #[Route('/lucky/number/{max}', name: 'app_lucky_number')]
    public function number(int $max, LoggerInterface $logger): Response
    {
        $logger->info('We are logging!');
        $number = random_int(0, $max);

        $logger->info('Here is our number' . $number);

        $client = new \GuzzleHttp\Client([
            'verify' => false
        ]);

        $response = $client->request('GET', 'https://exercisedb.p.rapidapi.com/exercises/bodyPart/back?limit=10', [
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

            // Push the created DTO object to the array
            $exercises[] = $exerciseDTO;

            $logger->info($exerciseDTO->getName());
        }

        return $this->render('lucky.html.twig', ['number' => $number, 'exercises' => $exercises]);
    }

    public function submitExercise(Request $request, LoggerInterface $logger): Response
    {
        // Get the selected exercise from the submitted form data
        $selectedExercise = $request->request->get('exercise');
        $logger->info($selectedExercise);
        // You can perform actions based on the selected exercise
        // For example, save it to a database, perform calculations, etc.

        // For demonstration, let's simply display the selected exercise
//        return $this->render('exercise/submitted.html.twig', [
//            'selectedExercise' => $selectedExercise,
//        ]);
        return new Response(
            '<html><body>Lucky number: '.$selectedExercise.'</body></html>'
        );
    }
}