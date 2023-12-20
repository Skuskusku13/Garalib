<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Technicien;
use App\Entity\Utilisateur;
use App\Form\RegistrationFormType;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher,
                             EntityManagerInterface $entityManager,
                             bool $formTechnicien = false): Response
    {

        $user = new Utilisateur();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $usertype = $request->request->get('selectOption');

            if($usertype === 'Client') {
                $client = new Client();
                $client->setIdUser($user);
                $user->setRoles(['ROLE_CLIENT']);
                $entityManager->persist($client);
                $entityManager->flush();
            } else {
                $technicien = new Technicien();
                $technicien->setIdUser($user);
                $user->setRoles(['ROLE_TECHNICIEN']);
                $entityManager->persist($user);
                $entityManager->flush();
            }

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
