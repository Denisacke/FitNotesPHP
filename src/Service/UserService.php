<?php

namespace App\Service;

use App\Entity\AuthenticationUser;
use App\Repository\AuthenticationUserRepository;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Log\LoggerInterface;

class UserService
{
    private AuthenticationUserRepository $userRepository;
    private Client $client;

    private LoggerInterface $logger;

    /**
     * @param AuthenticationUserRepository $userRepository
     * @param LoggerInterface $logger
     */
    public function __construct(AuthenticationUserRepository $userRepository, LoggerInterface $logger)
    {
        $this->userRepository = $userRepository;
        $this->client = new Client([
            'verify' => false
        ]);

        $this->logger = $logger;
    }

    public function saveUser(AuthenticationUser $user): AuthenticationUser
    {
        $this->userRepository->save($user);

        return $user;
    }

    public function update(): void
    {
        $this->userRepository->update();
    }

    /**
     * @throws GuzzleException
     */
    public function getUserDailyCalorieRequirements(AuthenticationUser $user): array{
        $response = $this->client->request('GET',
            'https://fitness-calculator.p.rapidapi.com/dailycalorie?age=' . $user->getAge() .
            '&gender=' . $user->getGender() .
            '&height=' . $user->getHeight() .
            '&weight=' . $user->getWeight() .
            '&activitylevel=level_' . $user->getActivityLevel(), [
            'headers' => [
                'X-RapidAPI-Host' => 'fitness-calculator.p.rapidapi.com',
                'X-RapidAPI-Key' => '47daba2431msh4a910d0f3b0f50dp13a2a9jsnd0e012cc6431',
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * @throws GuzzleException
     */
    public function getUserIdealWeight(AuthenticationUser $user): array{
        $response = $this->client->request('GET',
            'https://fitness-calculator.p.rapidapi.com/idealweight?gender=' . $user->getGender() .
            '&height=' . $user->getHeight(),
            [
            'headers' => [
                'X-RapidAPI-Host' => 'fitness-calculator.p.rapidapi.com',
                'X-RapidAPI-Key' => '47daba2431msh4a910d0f3b0f50dp13a2a9jsnd0e012cc6431',
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    public function getUserBodyFat(AuthenticationUser $user): ?array{
        try{
            $response = $this->client->request('GET',
                'https://fitness-calculator.p.rapidapi.com/bodyfat?age=' . $user->getAge() .
                '&gender=' . $user->getGender() .
                '&height=' . $user->getHeight() .
                '&weight=' . $user->getWeight() .
                '&neck=' . $user->getNeck() .
                '&waist=' . $user->getWaist() .
                '&hip=' . $user->getWeight() .
                '&activitylevel=level_' . $user->getActivityLevel(), [
                    'headers' => [
                        'X-RapidAPI-Host' => 'fitness-calculator.p.rapidapi.com',
                        'X-RapidAPI-Key' => '47daba2431msh4a910d0f3b0f50dp13a2a9jsnd0e012cc6431',
                    ],
                ]);
            return json_decode($response->getBody(), true);
        } catch (GuzzleException $exception) {
            $this->logger->error($exception);
            return null;
        }

    }

    /**
     * @return AuthenticationUser[]
     */
    public function findAllUsers(): array {
        return $this->userRepository->findAll();
    }

    public function findUserByName($name): AuthenticationUser
    {
        return $this->userRepository->findOneByUsername($name);
    }

    public function findUserById(int $id): AuthenticationUser
    {
        return $this->userRepository->findById($id);
    }
}