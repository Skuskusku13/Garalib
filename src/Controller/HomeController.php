<?php

namespace App\Controller;

use App\Entity\Technicien;
use App\Entity\Utilisateur;
use App\Repository\TechnicienRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(UtilisateurRepository $utilisateurRepository, TechnicienRepository $technicienRepository, Security $security): Response
    {

        $user = $this->getUser();

        dump($user);
        if($user instanceof Utilisateur ) {
            $user = $utilisateurRepository->find($this->getUser());
            $technicien = $user->getTechnicien();
            if($technicien instanceof Technicien && in_array('ROLE_TECHNICIEN', $user->getRoles(), true)) {
                $technicien = $technicienRepository->find($user->getTechnicien());
                $qual = $technicien->getQualifications();
                if (empty($qual)) {
                    return $this->redirectToRoute('app_technicien');
                }
            }
        }


        return $this->render('home/index.html.twig', [
            'app_home' => 'HomeController',
        ]);
    }
}
