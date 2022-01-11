<?php

namespace App\Controller;

use App\Repository\LivreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class LivreController extends AbstractController
{
    private int $PAGE_LIMIT = 8;

    #[Route('/api/livres', name: 'api_livres')]
    public function apiLivres(NormalizerInterface $normalizer, LivreRepository $repo): Response
    {

        $livres = $repo->findAll();
        $arr = [];
        $arr = $normalizer->normalize($livres, null, ['groups' => 'readed']);

        return $this->json($arr);
    }

    #[Route('/api/livres_filtre', name: 'api_livres_filtre')]
    public function apiLivresFiltre(Request $request, NormalizerInterface $normalizer, LivreRepository $repo): Response
    {

        $cat = $request->query->get("cat");
        $date_deb = $request->query->get("date_deb");
        $date_fin = $request->query->get("date_fin");
        $page = $request->query->get("p", 1);
        $limit = $this->PAGE_LIMIT;
        $res = $repo->getLivrePagineted($page, $limit, $cat, $date_deb, $date_fin);
        $total_result = $repo->getLivrePaginetedCount($cat, $date_deb, $date_fin);
        $arr = $normalizer->normalize($res, null, ['groups' => 'readed']);
        $res = array();
        $res['total_result'] = $total_result;
        $res['data'] = $arr;
        $res['page_limit'] = $limit;

        return $this->json($res);
    }
}
