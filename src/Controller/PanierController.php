<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\PlatRepository;
use App\Service\PanierService;
use Symfony\Component\HttpFoundation\Request;

class PanierController extends AbstractController
{

    private $panierService;

    public function __construct(PanierService $panierService)
    {
        $this->panierService = $panierService;
    }

    #[Route('/panier', name: 'app_panier')]
public function index(PlatRepository $platRepository): Response
{
    if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
        $this->addFlash('error', 'Vous devez être <a href="/login">connecté</a> pour accéder au panier.');
        return $this->redirectToRoute('app_index');
    }

    $commande_list = $this->panierService->getPanierQuantites();

    if (empty($commande_list)) {
        $this->addFlash('error', 'Votre panier est vide.');
        return $this->redirectToRoute('app_plats');
    }

    $plats = $platRepository->findBy(['id' => array_keys($commande_list)]);

    $platsAvecQuantites = [];
    $total = 0;

    foreach ($plats as $plat) {
        $quantite = $commande_list[$plat->getId()];
        $platsAvecQuantites[] = [
            'plat' => $plat,
            'quantite' => $quantite,
        ];
        $total += $plat->getPrix() * $quantite;
    }

    return $this->render('panier/index.html.twig', [
        'controller_name' => 'PanierController',
        'plats' => $platsAvecQuantites,
        'total' => $total,
    ]);
}

    #[Route('/panier/del/{id}', name: 'app_panier_del')]
    public function del_plat(int $id): Response
    {

        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            $this->addFlash('error', 'Vous devez être <a href="/login">connecté</a> pour accéder au panier.');
            return $this->redirectToRoute('app_index');
        }

        if ($this->panierService->getPanier() == []) {
            $this->addFlash('error', 'Votre panier est vide.');
            return $this->redirectToRoute('app_plats');
        }

        if (array_search($id, $this->panierService->getPanier()) === false) {
            $this->addFlash('error', 'Le plat n\'est pas dans le panier.');
            return $this->redirectToRoute('app_panier');
        }

        $this->panierService->removePanier($id);

        $this->addFlash('success', 'Le plat a été supprimé du panier.');
        return $this->redirectToRoute('app_panier');
    }

    #[Route('/panier/edit', name: 'app_panier_edit', methods: ['POST'])]
    public function edit(Request $request): Response
    {
        $id = $request->request->get('id');
        $value = (int) $request->request->get('quantity');
        

        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            $this->addFlash('error', 'Vous devez être <a href="/login">connecté</a> pour accéder au panier.');
            return $this->redirectToRoute('app_index');
        }

        if ($this->panierService->getPanier() == []) {
            $this->addFlash('error', 'Votre panier est vide.');
            return $this->redirectToRoute('app_plats');
        }

        if (!array_key_exists($id, $this->panierService->getPanierQuantites())) {
            $this->addFlash('error', 'Le plat n\'est pas dans le panier.');
            return $this->redirectToRoute('app_panier');
        }

        if ($value <= 0) {
            $this->panierService->removePanier($id);
            $this->addFlash('success', 'Le plat a été supprimé du panier.');
            return $this->redirectToRoute('app_panier');
        }

        if ($value > 10) {
            $this->addFlash('error', 'La quantité doit être inférieure à 10.');
            return $this->redirectToRoute('app_panier');
        }

        $this->panierService->editPanier($id, $value);

        $this->addFlash('success', 'La quantité du plat a été modifiée.');
        return $this->redirectToRoute('app_panier');
       
    }

    #[Route('/panier/reset', name: 'app_panier_reset')]
    public function reset(): Response
    {
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            $this->addFlash('error', 'Vous devez être <a href="/login">connecté</a> pour accéder au panier.');
            return $this->redirectToRoute('app_index');
        }

        if ($this->panierService->getPanier() == []) {
            $this->addFlash('error', 'Votre panier est vide.');
            return $this->redirectToRoute('app_plats');
        }

        $this->panierService->clearPanier();

        $this->addFlash('success', 'Le panier a été vidé.');
        return $this->redirectToRoute('app_plats');

    }
  
}