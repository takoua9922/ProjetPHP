<?php

namespace App\Controller;

use App\Repository\OpportunityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function dashboard(OpportunityRepository $opportunityRepository): Response
    {
        $user = $this->getUser();

        
        if (in_array('ROLE_ADMINISTRATION', $user->getRoles())) {
            $opportunities = $opportunityRepository->findBy(['createdBy' => $user]);

            return $this->render('dashboard/admin_dashboard.html.twig', [
                'opportunities' => $opportunities,
                'controller_name' => 'UsersController (Admin Dashboard)',
            ]);
        }

        if (in_array('ROLE_ETUDIANT', $user->getRoles())) {
            $opportunities = $opportunityRepository->findAll();

            return $this->render('opportunity/index.html.twig', [
                'opportunities' => $opportunities,
                'controller_name' => 'UsersController (User Dashboard)',
            ]);
        }

        if (in_array('ROLE_SOCIETE', $user->getRoles()) || in_array('ROLE_CLUB', $user->getRoles())) {
            $opportunities = $opportunityRepository->findBy(['createdBy' => $user]);

            return $this->render('dashboard/societe_dashboard.html.twig', [
                'opportunities' => $opportunities,
                'controller_name' => 'UsersController (Service Dashboard)',
            ]);
        }
        if (in_array('ROLE_CLUB', $user->getRoles())) {
            $opportunities = $opportunityRepository->findBy(['createdBy' => $user]);

            return $this->render('dashboard/club_dashboard.html.twig', [
                'opportunities' => $opportunities,
                'controller_name' => 'UsersController (Service Dashboard)',
            ]);
        }

        
        return $this->redirectToRoute('app_service');
    }
}
