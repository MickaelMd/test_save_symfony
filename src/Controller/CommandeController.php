<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\PanierService;
use App\Entity\Commande;
use App\Entity\Detail;
use App\Entity\Plat;
use Doctrine\ORM\EntityManagerInterface;

class CommandeController extends AbstractController
{
    private $panierService;
    private $entityManager;

    public function __construct(PanierService $panierService, EntityManagerInterface $entityManager)
    {
        $this->panierService = $panierService;
        $this->entityManager = $entityManager;
    }
    
    #[Route('/panier/valider', name: 'app_panier_valider', methods: ['POST'] ) ]
    public function valider(Request $request): Response
    {

        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            $this->addFlash('error', 'Vous devez être <a href="/login">connecté</a> pour accéder au panier.');
            return $this->redirectToRoute('app_index');
        }

        if ($this->panierService->getPanier() == []) {
            $this->addFlash('error', 'Votre panier est vide.');
            return $this->redirectToRoute('app_plats');
        }

        if ($request->request->get('cgv_check') === null) {
            
            $this->addFlash('error', 'Vous devez accepter les conditions générales de vente pour valider la commande.');
            return $this->redirectToRoute('app_panier');
        }

        $date = new \DateTimeImmutable();
        $plat_id = $this->panierService->GetPanier();
        $user = $this->getUser();
       
        
        $commande = new Commande();
        $commande->setUtilisateur($user);
        $commande->setDateCommande($date);
        $commande->setEtat(0);
        
        $this->entityManager->persist($commande);
    
        $platsGroupes = array_count_values($plat_id);

        foreach ($platsGroupes as $platId => $quantitePlat) {
        
            $plat = $this->entityManager->getRepository(Plat::class)->find($platId);

            if ($plat) {
                
                $detail = new Detail();
                $detail->setPlat($plat);  
                $detail->setQuantite($quantitePlat); 
                $detail->setTotal($plat->getPrix() * $quantitePlat); 
                $detail->setCommande($commande);

                $this->entityManager->persist($detail);

            } else {
                $this->addFlash('error', 'Un ou plusieurs plats n\'ont pas été trouvés.');
                return $this->redirectToRoute('app_panier');
            }
        }

        $this->entityManager->flush();
        $this->panierService->clearPanier();
        
        $this->addFlash('success', 'Votre commande a été validée avec succès.');
        return $this->redirectToRoute('app_index');

    }
}