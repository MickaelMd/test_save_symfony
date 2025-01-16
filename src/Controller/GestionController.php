<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Repository\CategorieRepository;
use App\Repository\PlatRepository;
use App\Repository\CommandeRepository;

class GestionController extends AbstractController
{
    #[Route('/gestion', name: 'app_gestion')]
    public function index(PlatRepository $platRepository, CategorieRepository $categorieRepository, CommandeRepository $commandeRepository) : Response
    {
        if ($this->getUser()) {
           
            if (!in_array('ROLE_CHEF', $this->getUser()->getRoles()) && !in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
                return $this->redirectToRoute('app_index'); 
            }
        } else {
            
            return $this->redirectToRoute('app_login'); 
        }
        

        $plats = $platRepository->findAll();
        $categories = $categorieRepository->findAll();
        $commandes = $commandeRepository->findAll();
        

        return $this->render('gestion/index.html.twig', [
            'controller_name' => 'GestionController',
            'plats' => $plats,
            'categories' => $categories,
            'commandes' => $commandes,
        ]);
    }
}