<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AlbumController extends AbstractController
{
    #[Route('/admin/album', name: 'app_admin_album')]
    public function index(): Response
    {
        return $this->render('admin/album/index.html.twig', [
            'controller_name' => 'AlbumController',
        ]);
    }
}
