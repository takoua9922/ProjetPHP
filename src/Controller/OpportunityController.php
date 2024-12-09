<?php

namespace App\Controller;

use App\Entity\Opportunity;
use App\Form\OpportunityType;
use App\Repository\OpportunityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
#[Route('/opportunity')]
class OpportunityController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route(name: 'app_opportunity_index', methods: ['GET'])]
    public function index(OpportunityRepository $opportunityRepository): Response
    {
        $opportunities = $opportunityRepository->findAll();

        // Ajoutez un dump ici pour vérifier le contenu de $opportunities
      
    
        return $this->render('opportunity/index.html.twig', [
            'opportunities' => $opportunities,
        ]);
    }

    #[Route('/new', name: 'app_opportunity_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Vérification que l'utilisateur a bien le rôle 'ROLE_ADMINISTRATION'
        if (!$this->isGranted('ROLE_ADMINISTRATION')) {
            throw new AccessDeniedException("Vous n'avez pas l'autorisation d'ajouter une opportunité.");
        }

        $opportunity = new Opportunity();
        $form = $this->createForm(OpportunityType::class, $opportunity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($opportunity);
            $entityManager->flush();

            return $this->redirectToRoute('app_opportunity_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('opportunity/new.html.twig', [
            'opportunity' => $opportunity,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_opportunity_show', methods: ['GET'])]
    public function show(Opportunity $opportunity): Response
    {
        // Allow all users to view opportunities (no role check needed)
        return $this->render('opportunity/show.html.twig', [
            'opportunity' => $opportunity,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_opportunity_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Opportunity $opportunity, EntityManagerInterface $entityManager): Response
{
    // Vérifier si l'utilisateur connecté est celui qui a créé l'opportunité
    $user = $this->getUser(); // L'utilisateur connecté
    if ($opportunity->getCreatedBy() !== $user) {
        throw $this->createAccessDeniedException('Vous n\'êtes pas autorisé à modifier cette opportunité.');
    }

    $form = $this->createForm(OpportunityType::class, $opportunity);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->flush(); // Sauvegarder les modifications

        return $this->redirectToRoute('app_opportunity_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('opportunity/edit.html.twig', [
        'opportunity' => $opportunity,
        'form' => $form,
    ]);
}

    #[Route('/{id}', name: 'app_opportunity_delete', methods: ['POST'])]
    public function delete(Request $request, Opportunity $opportunity, EntityManagerInterface $entityManager): Response
{
    // Vérifier si l'utilisateur connecté est celui qui a créé l'opportunité
    $user = $this->getUser(); // Utilisateur connecté
    if ($opportunity->getCreatedBy() !== $user) {
        throw $this->createAccessDeniedException('Vous n\'êtes pas autorisé à supprimer cette opportunité.');
    }

    // Validation du token CSRF
    if ($this->isCsrfTokenValid('delete'.$opportunity->getId(), $request->get('_token'))) {
        $entityManager->remove($opportunity);
        $entityManager->flush();
    }

    return $this->redirectToRoute('app_opportunity_index', [], Response::HTTP_SEE_OTHER);

}
#[Route('/my-opportunities', name: 'app_opportunity_my', methods: ['GET'])]
public function myOpportunities(OpportunityRepository $opportunityRepository): Response
{
    $user = $this->getUser();
    if (!$user) {
        throw new \Exception('Utilisateur non t rouvé.');
    }

    $opportunities = $opportunityRepository->findByCreatedBy($user);
    dump($opportunities); // Vérifiez que les opportunités sont récupérées

    return $this->render('opportunity/my_opportunities.html.twig', [
        'opportunities' => $opportunities,
    ]);
}




}
