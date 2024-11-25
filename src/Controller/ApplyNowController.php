<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ApplyNowController extends AbstractController
{
    #[Route('/apply/now', name: 'app_apply_now')]
    public function index(): Response
    {
        return $this->render('apply_now/index.html.twig', [
            'controller_name' => 'ApplyNowController',
        ]);
    }
}
