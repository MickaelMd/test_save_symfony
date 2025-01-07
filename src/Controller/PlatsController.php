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
       
        $plats = $platRepository->findAll();

      
        return $this->render('plats/index.html.twig', [
            'plats' => $plats,  
        ]);
    }
}