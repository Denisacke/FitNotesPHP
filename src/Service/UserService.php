<?php

namespace App\Service;

use App\Entity\AuthenticationUser;
use App\Repository\AuthenticationUserRepository;

class UserService
{
    private AuthenticationUserRepository $userRepository;

    /**
     * @param AuthenticationUserRepository $userRepository
     */
    public function __construct(AuthenticationUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function saveUser(AuthenticationUser $user): AuthenticationUser
    {
        $this->userRepository->save($user);

        return $user;
    }

    /**
     * @return AuthenticationUser[]
     */
    public function findAllUsers(): array {
        return $this->userRepository->findAll();
    }

    public function findUserById(int $id): AuthenticationUser
    {
        return $this->userRepository->findById($id);
    }
}