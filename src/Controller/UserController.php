<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\UserService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private UserService $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    #[Route(path: '/user/{id}', name: 'user_id')]
    public function fetchUser($id, LoggerInterface $logger): Response{

        $logger->info($this->userService->findUserById($id)->getName());
        return $this->render('test.html.twig', ['rightContent' => 'user/one_user.html.twig', 'user' => $this->userService->findUserById($id)]);
    }

    #[Route(path: '/usersave/test', name: 'user_test')]
    public function test(): Response{
        $user1 = new User('Test', 'test@gmail.com', 'testing', 175, 60, 23, 1);
        $user2 = new User('Test2', 'test@gmail.com', 'testing', 175, 55, 23, 5);
        $this->userService->saveUser($user1);
        $this->userService->saveUser($user2);


        echo 'saved users';
        return $this->render('user/user.html.twig');
    }

    #[Route(path: '/home', name: 'home_page')]
    public function renderDashboard(): Response{

        return $this->render('test.html.twig', ['rightContent' => 'user/home.html.twig']);
    }
}