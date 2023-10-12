<?php

namespace App\Controller;

use App\Entity\Label;
use App\Repository\LabelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LabelController extends AbstractController
{
    #[Route('/labels', name: 'app_labels', methods: ["GET","SET"])]
    public function listeLabel(LabelRepository $repo): Response
    {
        $labels = $repo->findall();
        return $this->render('label/listeLabel.html.twig', [
            'controller_name' => 'LabelController',
            'lesLabels' => $labels
        ]);
    }

    #[Route('/label/{id}', name: 'app_label', methods: ["GET","SET"])]
    public function ficheLabel(Label $label): Response
    {
        return $this->render('label/ficheLabel.html.twig', [
            'controller_name' => 'LabelController',
            'unLabel' => $label
        ]);
    }
}
