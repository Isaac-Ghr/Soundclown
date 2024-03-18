<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Repository\NationaliteRepository;

class NationaliteController extends AbstractController
{
    #[Route('/nationalites', name: 'app_nationalite_liste')]
    public function index(NationaliteRepository $nrepo): Response
    {
        // dd($nrepo->natioStats());
        $nationalites = $nrepo->natioStats();

        return $this->render('nationalite/liste.html.twig', [
            'controller_name' => 'NationaliteController',
            'nationalites' => $nationalites
        ]);
    }
}
