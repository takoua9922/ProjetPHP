<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class StimulusController extends AbstractController
{
    #[Route('/stimulus', name: 'app_stimulus')]
    public function index(): Response
    {
        return $this->render('stimulus/index.html.twig', [
            'controller_name' => 'StimulusController',
        ]);
    }
}
