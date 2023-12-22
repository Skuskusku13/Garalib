<?php

namespace App\Controller;

use App\Entity\Reparation;
use App\Entity\Technicien;
use App\Entity\Utilisateur;
use App\Form\ReparationType;
use App\Repository\ReparationRepository;
use App\Repository\TechnicienRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReparationController extends AbstractController
{
    #[Route('/reparation', name: 'app_reparation')]
    public function registerReparation(Request $request, UtilisateurRepository $utilisateurRepository, EntityManagerInterface $entityManager): Response
    {
        // Redirect to the previous page
        $referer = $request->headers->get('referer');
        $form = null;
        $user = $this->getUser();
        if($user instanceof Utilisateur) {
            $user = $utilisateurRepository->find($this->getUser());
            $technicien = $user->getTechnicien();
            if ($technicien instanceof Technicien) {
                $reparation = new Reparation();
                $form = $this->createForm(ReparationType::class, $reparation);
                $form->handleRequest($request);
                if($form->isSubmitted() && $form->isValid()) {
                    $reparation->setTechnicien($technicien);
                    $entityManager->persist($reparation);
                    $entityManager->flush();
                    return $this->redirectToRoute("app_reparation");
                }
            } else {
                return $this->redirect($referer);
            }
        }

        return $this->render('reparation/index.html.twig', [
            'reparationForm' => $form?->createView(),
        ]);
    }

    #[Route('/repation-historique', name: 'app_reparation-historique')]
    public function reparationHistorique(Request $request, ReparationRepository $reparationRepository) {

        $user = $this->getUser();
        $reparations = null;
        if ($user instanceof Utilisateur) {
            $technicien = $user->getTechnicien();
            if($technicien instanceof Technicien) {
                $reparations = $reparationRepository->findBy(['technicien' => $technicien->getId()]);

            } else {
                return $this->redirectToRoute('app_home');
            }
        } else {
            return $this->redirectToRoute('app_home');
        }


        return $this->render('reparation/historique.html.twig', [
            'app_reparation-historique' => 'Reparation Historique',
            'reparations' => $reparations
        ]);
    }
}
