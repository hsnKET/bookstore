<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    #[Route('/inscription', name: 'security_inscription')]
    public function insc(UserPasswordHasherInterface $encoder, Request $request, EntityManagerInterface $em): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $user->setRole("ROLE_ADMIN");
                $hash = $encoder->hashPassword($user, $user->getPassword());
                $user->setPassword($hash);
                $em->persist($user);
                $em->flush();
                $this->addFlash('success', 'Inscription terminée avec succès');
                return $this->redirectToRoute('security_inscription');
            } else {
                $this->addFlash('error', 'Les Données invalide');
            }
        }
        return $this->render('security/inscription.html.twig', [
            'controller_name' => 'SecurityController',
            'userForm' => $form->createView(),
        ]);
    }
    #[Route('/connexion', name: 'security_connexion')]
    public function connexion(): Response
    {
        return $this->render('security/connexion.html.twig', [
            'controller_name' => 'SecurityController'
        ]);
    }

    #[Route('/deconnexion', name: 'security_deconnexion')]
    public function deconnexion(): Response
    {
        return $this->render('security/connexion.html.twig', [
            'controller_name' => 'SecurityController'
        ]);
    }
}
