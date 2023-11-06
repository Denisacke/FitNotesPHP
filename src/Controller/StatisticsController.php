<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatisticsController extends AbstractController
{
    #[Route(path: '/progress', name: 'progress_page')]
    public function renderStatistics(): Response{

        return $this->render('test.html.twig', ['rightContent' => 'progress/progress.html.twig']);
    }
}