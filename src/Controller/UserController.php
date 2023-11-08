<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\UserService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

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

        $logger->info($this->userService->findUserById($id)->getUsername());
        return $this->render('test.html.twig', ['rightContent' => 'user/one_user.html.twig', 'user' => $this->userService->findUserById($id)]);
    }

    #[Route(path: '/usersave/test', name: 'user_test')]
    public function test(UserPasswordHasherInterface $passwordHasher, LoggerInterface $logger): Response{
        $user1 = new User('Test', 'test@gmail.com', 175, 60, 23, 1);
        $hashedPassword1 = $passwordHasher->hashPassword(
            $user1,
            'testing'
        );

        $user1->setPassword($hashedPassword1);

        $user2 = new User('Test2', 'test@gmail.com', 175, 55, 23, 5);
        $hashedPassword2 = $passwordHasher->hashPassword(
            $user2,
            'testing'
        );

        $user2->setPassword($hashedPassword2);

        $this->userService->saveUser($user1);
        $this->userService->saveUser($user2);

        return $this->render('user/user.html.twig');
    }

    #[Route(path: '/home', name: 'home_page')]
    public function renderDashboard(TokenStorageInterface $tokenStorage, Security $security): Response{
        return $this->render('test.html.twig', ['rightContent' => 'user/home.html.twig']);
    }
}