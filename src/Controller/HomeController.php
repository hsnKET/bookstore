<?php

namespace App\Controller;

use App\Repository\AuteurRepository;
use App\Repository\GenreRepository;
use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class HomeController extends AbstractController
{
    private int $PAGE_LIMIT = 8;

    #[Route('/', name: 'home')]
    public function index(GenreRepository $repoGenre, LivreRepository $repo, NormalizerInterface $normalizer): Response
    {


        $livresList = $repo->getLivrePagineted(1, $this->PAGE_LIMIT);
        $total_result = $repo->getLivrePaginetedCount();
        $genres = $repoGenre->findAll();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'livres_list' => $livresList,
            'total_result' => $total_result,
            'page_limit' => $this->PAGE_LIMIT,
            'current_page' => 1,
            'genres' => $genres,
        ]);
    }

    #[Route('/details/{id}', name: 'home_details')]
    public function livre_show(?int $id, LivreRepository $repo): Response
    {
        $livre = $repo->find($id);
        return $this->render('home/livre_details.html.twig', [
            'controller_name' => 'HomeController',
            'livre' => $livre
        ]);
    }

    #[Route('/search', name: 'home_search')]
    public function search(Request $request, LivreRepository $repo): Response
    {

        $q = $request->query->get('q', '');
        $livres = $repo->findByLikeField($q);

        return $this->render('home/search.html.twig', [
            'controller_name' => 'HomeController',
            'livres' => $livres,
            'q' => $q,
        ]);
    }
    #[Route('/auteur/{id}', name: 'home_auteur')]
    public function auteur(?int $id, AuteurRepository $repoA, LivreRepository $repo): Response
    {

        $auteur = $repoA->find($id);
        $livres_list = $repo->findByActeur($id);

        return $this->render('home/auteur.html.twig', [
            'controller_name' => 'HomeController',
            'livres_list' => $livres_list,
            'auteur' => $auteur,
        ]);
    }

    #[Route('/auteurs', name: 'home_auteur_list')]
    public function auteurs(AuteurRepository $repoA): Response
    {

        $auteurs = $repoA->findAll();

        return $this->render('home/auteurs.html.twig', [
            'controller_name' => 'HomeController',
            'auteurs' => $auteurs,
        ]);
    }
}
