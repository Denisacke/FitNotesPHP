<?php

namespace App\Controller;

use App\Controller\Forms\AuthenticationUserType;
use App\Entity\AuthenticationUser;
use App\Service\UserService;
use App\Service\WorkoutService;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private UserService $userService;
    private WorkoutService $workoutService;

    /**
     * @param UserService $userService
     * @param WorkoutService $workoutService
     */
    public function __construct(UserService $userService, WorkoutService $workoutService)
    {
        $this->userService = $userService;
        $this->workoutService = $workoutService;
    }


    #[Route(path: '/user/{id}', name: 'user_id')]
    public function fetchUser($id, LoggerInterface $logger): Response{

        $logger->info($this->userService->findUserById($id)->getUsername());
        return $this->render('test.html.twig', ['rightContent' => 'user/one_user.html.twig', 'user' => $this->userService->findUserById($id)]);
    }

    #[Route(path: '/usersave/test', name: 'user_test')]
    public function test(UserPasswordHasherInterface $passwordHasher, LoggerInterface $logger): Response{
        $user1 = new AuthenticationUser();
        $user1->setUsername('Test');
        $user1->setAge(23);
        $user1->setHeight(175);
        $user1->setActivityLevel(1);
        $hashedPassword1 = $passwordHasher->hashPassword(
            $user1,
            'testing'
        );

        $user1->setPassword($hashedPassword1);

        $this->userService->saveUser($user1);

        return $this->render('user/user.html.twig');
    }

    /**
     * @throws GuzzleException
     */
    #[Route(path: '/home', name: 'home_page')]
    public function renderDashboard(Security $security, LoggerInterface $logger): Response{

        $logger->info($this->userService->findUserByName($security->getUser()->getUserIdentifier())->getUsername());
        $requirements = $this->userService->getUserDailyCalorieRequirements($this->userService->findUserByName($security->getUser()->getUserIdentifier()));

        $authenticatedUser = $this->userService->findUserByName($security->getUser()->getUserIdentifier());
        return $this->render(
            'test.html.twig',
            [
                'rightContent' => 'user/home.html.twig',
                'user' => $security->getUser(),
                'BMR' => $requirements['data']['BMR'],
                'workouts' => $this->workoutService->findAllWorkoutsByUser($authenticatedUser)
            ]
        );
    }

    #[Route(path: '/signup', name: 'signup_page')]
    public function renderSignupPage(UserPasswordHasherInterface $passwordHasher, Request $request): Response
    {
        $user = new AuthenticationUser();
        $form = $this->createForm(AuthenticationUserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($passwordHasher->hashPassword($user, $user->getPassword()));
            $this->userService->saveUser($user);

            return $this->redirectToRoute('home_page');
        }

        return $this->render('security/signup.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}