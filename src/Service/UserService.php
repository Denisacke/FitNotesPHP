<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;

class UserService
{
    private UserRepository $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function saveUser(User $user): User
    {
        $this->userRepository->save($user);

        return $user;
    }

    /**
     * @return User[]
     */
    public function findAllUsers(): array {
        return $this->userRepository->findAll();
    }

    public function findUserById(int $id): User
    {
        return $this->userRepository->findById($id);
    }
}