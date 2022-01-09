<?php

namespace App\Controller;

use App\Repository\AuteurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class AuteurController extends AbstractController
{
    #[Route('/api/auteurs', name: 'api_auteurs')]
    public function apiAuteurs(Request $request, NormalizerInterface $normalizer, AuteurRepository $repo): Response
    {

        $auteurs = $repo->findByLikeField($request->query->get('q'));

        $arr = $normalizer->normalize($auteurs, null, ['groups' => 'readed']);
        return $this->json($arr);
    }
}
