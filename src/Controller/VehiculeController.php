<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Utilisateur;
use App\Entity\Vehicule;
use App\Form\VehiculeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use \Symfony\Component\HttpFoundation\Request;

class VehiculeController extends AbstractController
{
    #[Route('/vehicule', name: 'app_vehicule')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = null;
        $user = $this->getUser();
        if($user instanceof Utilisateur && in_array('ROLE_CLIENT', $user->getRoles(), true)) {
            $client = $user->getClient();
            if($client instanceof Client) {
                $vehicule = new Vehicule();
                $form = $this->createForm(VehiculeType::class, $vehicule);
                $form->handleRequest($request);
                $vehicule->setClient($user->getClient());
                dump($vehicule);
                $entityManager->persist($vehicule);
                $entityManager->flush();
            }
        } else {
            return $this->redirectToRoute('app_home');
        }



        return $this->render('vehicule/index.html.twig', [
            'vehiculeForm' => $form?->createView()
        ]);
    }
}
