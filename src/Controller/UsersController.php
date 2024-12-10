<?php
namespace App\Controller;

use App\Form\UsersType;
use App\Repository\OpportunityRepository;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function dashboard(OpportunityRepository $opportunityRepository): Response
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        switch (true) {
            case in_array('ROLE_ADMINISTRATION', $user->getRoles()):
                return $this->redirectToRoute('app_admin_dashboard');
            case in_array('ROLE_ETUDIANT', $user->getRoles()):
                return $this->redirectToRoute('app_user_dashboard');
            case in_array('ROLE_SOCIETE', $user->getRoles()):
                return $this->redirectToRoute('app_societe_dashboard');
            case in_array('ROLE_CLUB', $user->getRoles()):
                return $this->redirectToRoute('app_club_dashboard');
            default:
                return $this->redirectToRoute('app_404');
        }
    }

    #[Route('/admin/dashboard', name: 'app_admin_dashboard')]
    public function adminDashboard(OpportunityRepository $opportunityRepository): Response
    {
        $user = $this->getUser();
        $opportunities = $opportunityRepository->findBy(['createdBy' => $user]);

        return $this->render('dashboard/admin_dashboard.html.twig', [
            'opportunities' => $opportunities,
            'controller_name' => 'Admin Dashboard',
        ]);
    }

    #[Route('/admin/users', name: 'app_admin_users')]
    public function manageUsers(UsersRepository $usersRepository): Response
    {
        $users = $usersRepository->findAll();

        return $this->render('dashboard/dashboard.html.twig', [
            'users' => $users,
            'controller_name' => 'UsersController (Admin Users Management)',
        ]);
    }



    #[Route('/societe/dashboard', name: 'app_societe_dashboard')]
    public function societeDashboard(OpportunityRepository $opportunityRepository): Response
    {
        $user = $this->getUser();
        $opportunities = $opportunityRepository->findBy(['createdBy' => $user]);

        return $this->render('dashboard/societe_dashboard.html.twig', [
            'opportunities' => $opportunities,
            'controller_name' => 'Societe Dashboard',
        ]);
    }

    #[Route('/club/dashboard', name: 'app_club_dashboard')]
    public function clubDashboard(OpportunityRepository $opportunityRepository): Response
    {
        $user = $this->getUser();
        $opportunities = $opportunityRepository->findBy(['createdBy' => $user]);

        return $this->render('dashboard/club_dashboard.html.twig', [
            'opportunities' => $opportunities,
            'controller_name' => 'Club Dashboard',
        ]);
    }

    #[Route('/404', name: 'app_404')]
    public function notFound(): Response
    {
        return $this->render('404.html.twig', [
            'message' => 'Page non trouvée.',
        ]);
    }
}
