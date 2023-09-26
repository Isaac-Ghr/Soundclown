<?php

namespace App\Controller;

use App\Entity\Artiste;
use App\Repository\ArtisteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArtisteController extends AbstractController
{
    #[Route('/artistes', name: 'app_artistes')]
    public function listeArtiste(ArtisteRepository $repo): Response
    {
        $artistes = $repo->findall();
        return $this->render('artiste/listeArtiste.html.twig', [
            'controller_name' => 'ArtisteController',
            'lesArtistes' => $artistes
        ]);
    }

    #[Route('/artiste', name: 'app_artiste')]
    public function ficheArtiste(): Response
    {
        return $this->render('artiste/ficheArtiste.html.twig', [
            'controller_name' => 'ArtisteController',
        ]);
    }
}
