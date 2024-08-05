<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProjetRepository;
use App\Repository\StatutRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Projet;
use App\Form\ProjetType;
use Symfony\Component\Security\Http\Attribute\IsGranted;
class ProjetController extends AbstractController
{
    public function __construct(
        private ProjetRepository $projetRepository,
        private StatutRepository $statutRepository,
        private EntityManagerInterface $entityManager,
    )
    {
    }

    #[Route('/', name: 'app_projets')]

    public function projets(): Response
    {
        $user = $this->getUser();
        $roles = $user->getRoles();
    
        $projets = [];
    
        if (in_array('ROLE_ADMIN', $roles)) {
            // Administrateurs - récupérer tous les projets
            $projets = $this->projetRepository->findBy(['archive' => false]);
        } else {
            // Utilisateurs normaux - récupérer les projets assignés à l'utilisateur connecté
            $allProjets = $this->projetRepository->findBy(['archive' => false]);

            foreach ($allProjets as $projet) {
                foreach ($projet->getEmployes() as $employe) {
                    if ($employe === $user) {
                        $projets[] = $projet;
                        break;
                    }
                }
            }      
        }

        return $this->render('projet/liste.html.twig', [
            'projets' => $projets,
        ]);
    }

    #[Route('/projets/ajouter', name: 'app_projet_add')]
    #[IsGranted('ROLE_ADMIN')]
    public function ajouterProjet(Request $request): Response
    {  
        $projet = new Projet();

        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $projet->setArchive(false);
            $this->entityManager->persist($projet);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_projet', ['id' => $projet->getId()]);
        }


        return $this->render('projet/nouveau.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/projets/{id}', name: 'app_projet')]
    #[IsGranted('acces_projet', 'id', "Vous ne pouvez accèder à ce projet", 403)]
    public function projet(int $id): Response
    {  
        $statuts = $this->statutRepository->findAll();
        $projet = $this->projetRepository->find($id);

        if(!$projet || $projet->isArchive()) {
            return $this->redirectToRoute('app_projets');
        }

        return $this->render('projet/projet.html.twig', [
            'projet' => $projet,
            'statuts' => $statuts,
        ]);
    }

    #[Route('/projets/{id}/archiver', name: 'app_projet_archive')]
    #[IsGranted('ROLE_ADMIN')]
    public function archiverProjet(int $id): Response
    {  
        $projet = $this->projetRepository->find($id);

        if(!$projet || $projet->isArchive()) {
            return $this->redirectToRoute('app_projets');
        }

        $projet->setArchive(true);
        $this->entityManager->flush();
        
        return $this->redirectToRoute('app_projets');
    }


    #[Route('/projets/{id}/editer', name: 'app_projet_edit')]
    #[IsGranted('ROLE_ADMIN')]
    public function editerProjet(int $id, Request $request): Response
    {  
        $projet = $this->projetRepository->find($id);

        if(!$projet || $projet->isArchive()) {
            return $this->redirectToRoute('app_projets');
        }

        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $projet->setArchive(false);
            $this->entityManager->flush();
            return $this->redirectToRoute('app_projet', ['id' => $projet->getId()]);
        }

        return $this->render('projet/editer.html.twig', [
            'projet' => $projet,
            'form' => $form->createView(),
        ]);
    }
}
