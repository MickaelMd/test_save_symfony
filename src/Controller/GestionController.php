<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Repository\CategorieRepository;
use App\Repository\PlatRepository;
use App\Repository\CommandeRepository;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class GestionController extends AbstractController
{
    #[Route('/gestion', name: 'app_gestion')]
    public function index(PlatRepository $platRepository, CategorieRepository $categorieRepository, CommandeRepository $commandeRepository) : Response
    {

        if (!$this->isGranted('ROLE_CHEF') && !$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_index');
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

    #[Route('/update-plat', name: 'update_plat', methods: ['POST'])]
public function updatePlat(Request $request, PlatRepository $platRepository, EntityManagerInterface $em): Response
{

    if (!$this->isGranted('ROLE_CHEF') && !$this->isGranted('ROLE_ADMIN')) {
        return $this->redirectToRoute('app_index');
    }

    $id = $request->request->get('id');
    $libelle = $request->request->get('libelle');
    $description = $request->request->get('description');
    $prix = $request->request->get('prix');
    $image = $request->request->get('image');
    $active = $request->request->get('active') === 'on';

    $plat = $platRepository->find($id);

    if (!$plat) {
        $this->addFlash('danger', 'Plat non trouvé.');
        return $this->redirectToRoute('app_gestion');
    }

    $plat->setLibelle($libelle);
    $plat->setDescription($description);
    $plat->setPrix($prix);
    $plat->setImage($image);
    $plat->setActive($active);

    $em->persist($plat);
    $em->flush();

    $this->addFlash('success', 'Plat modifié avec succès.');
    return $this->redirectToRoute('app_gestion');
}

}