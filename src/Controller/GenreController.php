<?php

namespace App\Controller;

use App\Repository\GenreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class GenreController extends AbstractController
{

    #[Route('/api/genres', name: 'api_genres')]
    public function apigeners(Request $request, NormalizerInterface $normalizer, GenreRepository $repo): Response
    {
        $genres = $repo->findByLikeField($request->query->get('q'));
        $arr = $normalizer->normalize($genres, null, ['groups' => 'readed']);
        return $this->json($arr);
    }
}
