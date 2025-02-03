<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\PlatRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CommandeRepository;
use App\Repository\DetailRepository;
use App\Form\ProfilType;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function index(CommandeRepository $commandeRepository, DetailRepository $detailRepository, PlatRepository $platRepository, ProfilType $form): Response
    {
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            $this->addFlash('error', 'Vous devez être <a href="/login">connecté</a> pour accéder à votre Profil.');
            return $this->redirectToRoute('app_index');
        }
    
        $user = $this->getUser();
        /** @var \App\Entity\User|null $user */

        $id = $user->getId();
        $commandes = $commandeRepository->findBy(['utilisateur' => $id]);
        $commandesWithTotal = [];

        foreach ($commandes as $commande) {
            $details = $detailRepository->findBy(['commande' => $commande->getId()]);
            $total = 0;
            foreach ($details as $detail) {
                $total += $detail->getTotal();
            }
            $commandesWithTotal[] = [
                'commande' => $commande,
                'total' => $total,
            ];
        }

        return $this->render('profil/index.html.twig', [
            'controller_name' => 'ProfilController',
            'user' => $user,
            'commandesWithTotal' => $commandesWithTotal,
        ]);
    }

    #[Route('/delete_acount', name: 'app_profil_delete', methods: ['POST'])]
    public function delete_acount(): Response
    {
        return $this->redirectToRoute('app_index');
    }
}