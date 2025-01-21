<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PlatRepository;
use App\Service\PanierService;

class PlatsController extends AbstractController
{
    private $panierService;

    
    public function __construct(PanierService $panierService)
    {
        $this->panierService = $panierService;
    }

    #[Route('/plats', name: 'app_plats')]
    public function index(PlatRepository $platRepository): Response
    {

        

        $plats = $platRepository->findBy(['active' => 1]);

        return $this->render('plats/index.html.twig', [
            'plats' => $plats,  
        ]);
    }

    #[Route('/plats/{id}', name: 'app_plat_show')]
    public function show(int $id, PlatRepository $platRepository): Response
    {
        $plat = $platRepository->find($id);

        if (!$plat) {
            return $this->redirectToRoute('app_plats');
        }

        return $this->render('plats/plat.html.twig', [
            'plat' => $plat,
        ]);
    }

    #[Route('/plats/add/{id}', name: 'app_plat_show_add')]
    public function addToPanier($id, PlatRepository $platRepository): Response
    {


        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            $this->addFlash('error', 'Vous devez être <a href="/login">connecté</a> pour pouvoir passer une commande.');
            // $this->panierService->clearPanier();
            return $this->redirectToRoute('app_plats');
        }
       
        $plat = $platRepository->find($id);
        if ($id == "test") {
            $this->addFlash('error', '???????????');
            return $this->redirectToRoute('app_plats');
        }
        if (!$plat) {

            $this->addFlash('error', 'Une erreur est survenue, le plat n\'a pas été trouvé.');
            return $this->redirectToRoute('app_plats');
        }


        $this->panierService->AddToPanier($id);
        
        $this->addFlash('success', 'Le produit a été ajouté à votre panier.');
        return $this->redirectToRoute('app_plats');
    }
}