<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UpcomingMeetingsController extends AbstractController
{
    #[Route('/upcoming/meetings', name: 'app_upcoming_meetings')]
    public function index(): Response
    {
        return $this->render('upcoming_meetings/index.html.twig', [
            'controller_name' => 'UpcomingMeetingsController',
        ]);
    }
}
