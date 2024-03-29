<?php

namespace App\Controller;

use App\Entity\AuthenticationUser;
use App\Entity\DTO\WorkoutDTO;
use App\Entity\DTO\WorkoutMapper;
use App\Entity\Workout;
use App\Form\AuthenticationUserType;
use App\Form\UpdateUserType;
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

    private function mapWorkout(Workout $workout): WorkoutDTO{
        return WorkoutMapper::mapFromWorkoutToWorkoutDTO($workout);
    }

    /**
     * @throws GuzzleException
     */
    #[Route(path: '/home', name: 'home_page')]
    public function renderDashboard(Security $security, LoggerInterface $logger): Response{

        $authenticatedUser = $this->userService->findUserByName($security->getUser()->getUserIdentifier());
        $requirements = $this->userService->getUserDailyCalorieRequirements($authenticatedUser);
        $bodyFatPercentage = $this->userService->getUserBodyFat($authenticatedUser);
        $workouts = array_map([$this, 'mapWorkout'], $this->workoutService->findAllWorkoutsByUser($authenticatedUser));
        return $this->render(
            'test.html.twig',
            [
                'rightContent' => 'user/home.html.twig',
                'user' => $security->getUser(),
                'BMR' => $requirements['data']['BMR'],
                'bodyFatPercentage' => $bodyFatPercentage['data']['Body Fat Mass'] ?? null,
                'workouts' => $workouts,
                'workoutsComputationArray' => json_encode($workouts)
            ]
        );
    }

    #[Route(path: '/update-user', name: 'update_user_page')]
    public function renderUserUpdateProfilePage(UserPasswordHasherInterface $passwordHasher,
                                                Security $security,
                                                Request $request): Response
    {
        $authenticatedUser = $this->userService->findUserByName($security->getUser()->getUserIdentifier());
        $userUpdatableEntity = clone($authenticatedUser);

        $userUpdatableEntity->setPassword('');

        $form = $this->createForm(UpdateUserType::class, $userUpdatableEntity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($passwordHasher->isPasswordValid($authenticatedUser, $userUpdatableEntity->getPassword())){
                $authenticatedUser->setHip($userUpdatableEntity->getHip());
                $authenticatedUser->setNeck($userUpdatableEntity->getNeck());
                $authenticatedUser->setWaist($userUpdatableEntity->getWaist());
                $authenticatedUser->setUsername($userUpdatableEntity->getUsername());
                $authenticatedUser->setActivityLevel($userUpdatableEntity->getActivityLevel());
                $authenticatedUser->setAge($userUpdatableEntity->getAge());
                $authenticatedUser->setGender($userUpdatableEntity->getGender());
                $this->userService->update();
            }

            return $this->redirectToRoute('home_page');
        }

        return $this->render('security/signup.html.twig', [
            'form' => $form->createView(),
            'title' => 'Update profile data'
        ]);
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
            'title' => 'Register'
        ]);
    }


}