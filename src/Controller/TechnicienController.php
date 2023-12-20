<?php

namespace App\Controller;

use App\Entity\Technicien;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TechnicienController extends AbstractController
{
    #[Route('/inscription-technicien', name: 'app_technicien')]
    public function registerTechnicien(Request $request): Response
    {
        $technicien = new Technicien();


        return $this->render('technicien/index.html.twig', [
            'controller_name' => 'TechnicienController',
        ]);
    }
}
