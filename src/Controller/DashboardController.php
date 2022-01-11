<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Entity\Genre;
use App\Entity\Livre;
use App\Form\AuteurType;
use App\Form\GenreType;
use App\Form\LivreType;
use App\Repository\AuteurRepository;
use App\Repository\GenreRepository;
use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_ADMIN')]
class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    #[Route('/dashboard/auteur', name: 'dashboard_auteur')]
    public function auteur(AuteurRepository $repo): Response
    {
        return $this->render('dashboard/auteur.html.twig', [
            'controller_name' => 'DashboardController',
            'auteurList' => $repo->findAll(),
        ]);
    }

    #[Route('/dashboard/auteur/{id}/edit', name: 'dashboard_auteur_edit')]
    #[Route('/dashboard/auteur/add', name: 'dashboard_auteur_add')]
    public function auteur_add_edit(AuteurRepository $repo, EntityManagerInterface $em, Request $request): Response
    {
        $auteur = new Auteur();
        if ($request->get('id')) {
            $formTitle = "Modifier";
            $auteur = $repo->find($request->get('id'));
        } else
            $formTitle = "Ajouter";

        $form = $this->createForm(AuteurType::class, $auteur);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em->persist($auteur);
                $em->flush();
                if ($formTitle == "Ajouter")
                    $this->addFlash('success', 'L\'auteur est ajouté!');
                else {
                    $this->addFlash('success', 'L\'Auteur est mis à jour!');
                }
                return $this->redirectToRoute('dashboard_auteur');
            } else {

                $this->addFlash('error', 'Les données invalide');
            }
        }
        return $this->render('dashboard/auteur_add.html.twig', [
            'controller_name' => 'DashboardController',
            'formAuteur' => $form->createView(),
            'formTitle' => $formTitle,
            'auteurModel' => $auteur,
        ]);
    }

    #[Route('/dashboard/auteur/{id}/delete', name: 'dashboard_auteur_delete')]
    public function auteur_delete(?int $id = null, AuteurRepository $repo, EntityManagerInterface $em, Request $request): Response
    {
        $auteur = $repo->find($id);
        $em->remove($auteur);
        $em->flush();
        $this->addFlash('error', 'Auteur est supprimer');
        return $this->redirectToRoute('dashboard_auteur');
    }


    #[Route('/dashboard/livre', name: 'dashboard_livre')]
    public function livre(LivreRepository $repo): Response
    {
        return $this->render('dashboard/livre.html.twig', [
            'controller_name' => 'DashboardController',
            'livreList' => $repo->findAll(),
        ]);
    }

    #[Route('/dashboard/livre/{id}/edit', name: 'dashboard_livre_edit')]
    #[Route('/dashboard/livre/add', name: 'dashboard_livre_add')]
    public function livre_add_edit(LivreRepository $repo, ?int $id = null, Request $request, EntityManagerInterface $em): Response
    {
        $is_invalid = false;
        $isbn_invalid = false;
        $formTitle = "Ajouter";
        $livre = new Livre();
        if ($id) {
            $formTitle = "Modifier";
            $livre = $repo->find($id);
        }
        $form = $this->createForm(LivreType::class, $livre);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em->persist($livre);
                $em->flush();
                if ($formTitle == "Ajouter")
                    $this->addFlash('success', 'Le livre est ajouté!');
                else
                    $this->addFlash('success', 'Le livre  est mis à jour!');
                return $this->redirectToRoute('dashboard_livre');
            } else {
                $is_invalid = true;
                $isbn_invalid = $form['isbn']->getErrors();
                $this->addFlash('error', 'Les données invalide');
            }
        }
        return $this->render('dashboard/livre_add.html.twig', [
            'controller_name' => 'DashboardController',
            'formLivre' => $form->createView(),
            'formTitle' => $formTitle,
            'livreModel' => $livre,
            'is_invalid' => $is_invalid,
            'isbn_invalid' => $isbn_invalid,
        ]);
    }
    #[Route('/dashboard/livre/{id}/delete', name: 'dashboard_livre_delete')]
    public function livre_delete(?int $id = null, LivreRepository $repo, EntityManagerInterface $em): Response
    {
        $livre = $repo->find($id);
        $em->remove($livre);
        $em->flush();
        $this->addFlash('error', 'Livre est supprimer');
        return $this->redirectToRoute('dashboard_livre');
    }
    #[Route('/dashboard/genre', name: 'dashboard_genre')]
    public function genre(GenreRepository $repo): Response
    {
        return $this->render('dashboard/genre.html.twig', [
            'controller_name' => 'DashboardController',
            'genreList' => $repo->findAll(),
        ]);
    }

    #[Route('/dashboard/genre/{id}/edit', name: 'dashboard_genre_edit')]
    #[Route('/dashboard/genre/add', name: 'dashboard_genre_add')]
    public function genre_add_edit(?int $id = null, Request $request, GenreRepository $repo, EntityManagerInterface $em): Response
    {
        $formTitle = "Ajouter";
        $genre = new Genre();
        if ($id) {
            $formTitle = "Modifier";
            $genre = $repo->find($id);
        }
        $form = $this->createForm(GenreType::class, $genre);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em->persist($genre);
                $em->flush();
                if ($formTitle == "Ajouter")
                    $this->addFlash('success', 'Le genre est ajouté!');
                else
                    $this->addFlash('success', 'Le genre  est mis à jour!');
                return $this->redirectToRoute('dashboard_genre');
            } else {
                $this->addFlash('error', 'Les données invalide');
            }
        }
        return $this->render('dashboard/genre_add.html.twig', [
            'controller_name' => 'DashboardController',
            'formGenre' => $form->createView(),
            'formTitle' => $formTitle,
            'genreModel' => $genre
        ]);
    }

    #[Route('/dashboard/genre/{id}/delete', name: 'dashboard_genre_delete')]
    public function genre_delete(?int $id = null, GenreRepository $repo, EntityManagerInterface $em): Response
    {
        $genre = $repo->find($id);
        if (count($genre->getLivres())) {
            $this->addFlash('error', 'Genre est liée a un(ou plusieur) livre(s)');
        } else {
            $em->remove($genre);
            $em->flush();
            $this->addFlash('success', 'Genre est supprimer');
        }
        return $this->redirectToRoute('dashboard_genre');
    }
}
