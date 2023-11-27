<?php

namespace App\Service;

use App\Entity\AuthenticationUser;
use App\Repository\AuthenticationUserRepository;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class UserService
{
    private AuthenticationUserRepository $userRepository;
    private Client $client;

    /**
     * @param AuthenticationUserRepository $userRepository
     */
    public function __construct(AuthenticationUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->client = new Client([
            'verify' => false
        ]);
    }

    public function saveUser(AuthenticationUser $user): AuthenticationUser
    {
        $this->userRepository->save($user);

        return $user;
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