<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Nationalite;
use App\Repository\NationaliteRepository;
use App\Form\NationaliteType;
use Doctrine\ORM\EntityManagerInterface;

class NationaliteController extends AbstractController
{
    #[Route('/admin/nationalites', name: 'app_admin_nationalite_liste')]
    public function index(NationaliteRepository $nrepo): Response
    {
        $natios = $nrepo->findAll();
        return $this->render('admin/nationalite/index.html.twig', [
            'controller_name' => 'NationaliteController',
            'nationalites' => $natios,
        ]);
    }
    
    #[Route('/admin/nationalite', name: 'app_admin_nationalite_create')]
    #[Route('/admin/nationalite/{id}', name: 'app_admin_nationalite_update')]
    public function formulaire(?Nationalite $natio, Request $req, EntityManagerInterface $man): Response
    {
        if (!$natio) { $natio = new Nationalite(); }
        $form = $this->createForm(NationaliteType::class, $natio);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $man->persist($natio);
            $man->flush();
            return $this->redirectToRoute('app_admin_nationalite_liste');
        }

        return $this->render('admin/nationalite/formulaire.html.twig', [
            'controller_name' => 'NationaliteController',
            'natioForm' => $form->createView(),
        ]);
    }

    #[Route('/admin/nationalite/suppr/{id}', name: 'app_admin_nationalite_suppr')]
    public function supprArtiste(Nationalite $natio, EntityManagerInterface $manager): Response
    {
        if ($natio->getArtistes()->count() > 0) {
            $this->addFlash("danger", "Suppression annulée : cette nationalité concerne au moins un artiste");
            return $this->redirectToRoute('app_admin_nationalite_liste');
        }

        $manager->remove($natio);
        $manager->flush();
        $this->addFlash("success", "L'artiste a bien été supprimé");
        return $this->redirectToRoute('app_admin_nationalite_liste');
    }
}
