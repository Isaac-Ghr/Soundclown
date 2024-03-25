<?php

namespace App\Controller;

use App\Entity\Artiste;
use App\Repository\ArtisteRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ArtistRechercheType;

class ArtisteController extends AbstractController
{
    #[Route('/artistes', name: 'app_artistes')]
    public function listeArtiste(ArtisteRepository $repo, PaginatorInterface $paginator, Request $request): Response
    {
        $nom = null;
        $natioID = null;

        $form = $this->createForm(ArtistRechercheType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $nom = $form->get('nom')->getData();
            $natio = $form->get('nationalite')->getData();
            $natioID = $natio ? $natio->getId() : null;
        }

        $artistes = $paginator->paginate(
            $repo->listeArtistesFiltreP($nom, $natioID), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            8 /*limit per page*/
        );

        return $this->render('artiste/listeArtiste.html.twig', [
            'controller_name' => 'ArtisteController',
            'recherche' => $form->createView(),
            'lesArtistes' => $artistes
        ]);
    }

    #[Route('/artiste/{id}', name: 'app_artiste')]
    public function ficheArtiste(Artiste $artiste): Response
    {
        return $this->render('artiste/ficheArtiste.html.twig', [
            'controller_name' => 'ArtisteController',
            'unArtiste' => $artiste
        ]);
    }
}
