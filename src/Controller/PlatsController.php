<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PlatRepository;

class PlatsController extends AbstractController
{
    #[Route('/plats', name: 'app_plats')]
    public function index(PlatRepository $platRepository): Response
    {
       
        $plats = $platRepository->findBy(['active' => 1]);
        // $plats = [];

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

}