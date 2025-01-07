<?php

namespace App\Controller;

use App\Entity\Categorie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CategorieRepository;

class CategoriesController extends AbstractController
{
    #[Route('/categories', name: 'app_categories')]
    public function index(CategorieRepository $categorieRepository): Response
    {

        $categories = $categorieRepository->findAll();

        return $this->render('categories/index.html.twig', [
            'categories' => $categories,
        ]);
    }
}