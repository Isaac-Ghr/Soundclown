<?php

namespace App\Controller;

use App\Entity\Album;
use App\Repository\AlbumRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AlbumController extends AbstractController
{
    #[Route('/albums', name: 'app_albums')]
    public function listeAlbum(AlbumRepository $repo, PaginatorInterface $paginator, Request $request): Response
    {
        $albums = $paginator->paginate(
            $repo->listeAlbumsComplete(), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            6 /*limit per page*/
        );

        return $this->render('album/listeAlbum.html.twig', [
            'controller_name' => 'AlbumController',
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
