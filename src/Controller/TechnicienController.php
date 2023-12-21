<?php

namespace App\Controller;

use App\Entity\Technicien;
use App\Entity\Utilisateur;
use App\Form\TechnicienType;
use App\Repository\TechnicienRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TechnicienController extends AbstractController
{
    #[Route('/inscription-technicien', name: 'app_technicien')]
    public function registerTechnicien(Request                $request, UtilisateurRepository $utilisateurRepository, TechnicienRepository $technicienRepository,
                                       EntityManagerInterface $entityManager): Response
    {
        $form = null;
        $user = $this->getUser();
        if ($user instanceof Utilisateur) {
            $user = $utilisateurRepository->find($this->getUser());
            $technicien = $user->getTechnicien();
            if ($technicien instanceof Technicien && empty($technicien->getQualifications())) {
                $technicien = $technicienRepository->find($user->getTechnicien());
                $form = $this->createForm(TechnicienType::class, $technicien);
                $form->handleRequest($request);
                $qualif = $request->request->all();

                if ($form->isSubmitted() && $form->isValid()) {
                    $entityManager->persist($technicien);
                    $entityManager->flush();
                    return $this->redirectToRoute('app_home');
                }
            } else {
                return $this->redirectToRoute('app_home');
            }
        }

        return $this->render('technicien/index.html.twig', [
            'formTechnicien' => $form?->createView(),
        ]);
    }
}
