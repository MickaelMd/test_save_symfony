<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\PlatRepository;
use App\Repository\CategorieRepository;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(PlatRepository $platRepository, CategorieRepository $categorieRepository): Response
    {

        $plats = $platRepository->findBy(['active' => 1], ['libelle' => 'ASC'], 5);
        $categories = $categorieRepository->findBy(['active' => 1]);

        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
            'plats' => $plats,
            'categories' => $categories,
        ]);
    }
}