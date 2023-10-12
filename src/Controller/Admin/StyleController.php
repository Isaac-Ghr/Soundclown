<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StyleController extends AbstractController
{
    #[Route('/admin/style', name: 'app_admin_style')]
    public function index(): Response
    {
        return $this->render('admin/style/index.html.twig', [
            'controller_name' => 'StyleController',
        ]);
    }
}
