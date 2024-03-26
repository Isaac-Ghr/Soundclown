<?php

namespace App\Controller;

use App\Entity\Album;
use App\Form\AlbumRechercheType;
use App\Repository\AlbumRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AlbumController extends AbstractController
{
    #[Route('/albums', name: 'app_albums')]
    public function listeAlbum(AlbumRepository $repo, PaginatorInterface $paginator, Request $request): Response
    {
        $nom = null;
        $styleID = null;

        $form = $this->createForm(AlbumRechercheType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $nom = $form->get('nom')->getData();
            $style = $form->get('style')->getData();
            $styleID = $style ? $style->getID() : null;
        }

        $albums = $paginator->paginate(
            $repo->listeAlbumsFiltre($nom, $styleID), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            8 /*limit per page*/
        );

        return $this->render('album/listeAlbum.html.twig', [
            'controller_name' => 'AlbumController',
            'recherche' => $form->createView(),
            'lesAlbums' => $albums
        ]);
    }

    #[Route('/album/{id}', name: 'app_album')]
    public function ficheAlbum(Album $album): Response
    {
        return $this->render('album/ficheAlbum.html.twig', [
            'controller_name' => 'AlbumController',
            'unAlbum' => $album
        ]);
    }
}
