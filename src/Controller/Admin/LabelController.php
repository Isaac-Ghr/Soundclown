<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LabelController extends AbstractController
{
    #[Route('/admin/label', name: 'app_admin_label')]
    public function index(): Response
    {
        return $this->render('admin/label/index.html.twig', [
            'controller_name' => 'LabelController',
        ]);
    }
}
