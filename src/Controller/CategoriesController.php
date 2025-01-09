<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CategorieRepository;


class CategoriesController extends AbstractController
{
    #[Route('/categories', name: 'app_categories')]
    public function index(CategorieRepository $categorieRepository): Response
    {
        
        $categories = $categorieRepository->findBy(['active' => 1]);

        return $this->render('categories/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    // #[Route('/categories/{id}', name: 'app_categories_show')]
    // public function show(int $id, CategorieRepository $categorieRepository): Response
    // {
    //     $categorie = $categorieRepository->find($id);

    //     if (!$categorie) {
    //         return $this->redirectToRoute('app_categories');
    //     }

    //     return $this->render('categories/categorie.html.twig', [
    //         'categories' => $categorie,
    //     ]);
    // }
}