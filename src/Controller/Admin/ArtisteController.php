<?php

namespace App\Controller\Admin;

use Doctrine\ORM\EntityManagerInterface;
use App\Form\ArtisteType;
use App\Entity\Artiste;
use App\Repository\ArtisteRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArtisteController extends AbstractController
{
    #[Route('/admin/artistes', name: 'app_admin_artistes')]
    public function listeArtiste(ArtisteRepository $repo, PaginatorInterface $paginator, Request $request): Response
    {
        $artistes = $paginator->paginate(
            $repo->listeArtistesCompleteP(), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            6 /*limit per page*/
        );

        return $this->render('admin/artiste/listeArtiste.html.twig', [
            'controller_name' => 'ArtisteController',
            'lesArtistes' => $artistes
        ]);
    }

    #[Route('/admin/artiste/{id}', name: 'app_admin_artiste_edit', methods: ["GET", "POST"])]
    #[Route('/admin/artiste', name: 'app_admin_artiste_create', methods: ["GET", "POST"])]
    public function formArtiste(?Artiste $artiste, Request $request, EntityManagerInterface $manager): Response
    {
        if ($artiste == null) { $artiste = New Artiste(); }
        $form = $this->createForm(ArtisteType::class, $artiste);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($artiste);
            $manager->flush();
            return $this->redirectToRoute('app_admin_artistes');
        }
        return $this->render('admin/artiste/formulaireArtiste.html.twig', [
            'controller_name' => 'ArtisteController',
            'formArtiste' => $form->createView()
        ]);
    }
}
