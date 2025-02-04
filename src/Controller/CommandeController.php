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
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Csrf\CsrfToken;

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
    public function valider(Request $request, CsrfTokenManagerInterface $csrfTokenManager): Response
    {

        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            $this->addFlash('error', 'Vous devez être <a href="/login">connecté</a> pour accéder au panier.');
            return $this->redirectToRoute('app_index');
        }

        if ($this->panierService->getPanier() == []) {
            $this->addFlash('error', 'Votre panier est vide. <script> localStorage.setItem("panier", JSON.stringify([]));</script>');
            return $this->redirectToRoute('app_plats');
        }

        if ($request->request->get('cgv_check') === null) {
            
            $this->addFlash('error', 'Vous devez accepter les conditions générales de vente pour valider la commande.');
            return $this->redirectToRoute('app_panier');
        }

        $token = new CsrfToken('valider_commande', $request->request->get('_csrf_token'));
        if (!$csrfTokenManager->isTokenValid($token)) {
            $this->addFlash('error', 'Token CSRF invalide.');
            return $this->redirectToRoute('app_panier');
        }

        $date = new \DateTimeImmutable();
        $plat_id = $this->panierService->GetPanier();
        $user = $this->getUser();
       
        
        $commande = new Commande();
        $commande->setUtilisateur($user);
        $commande->setDateCommande($date);
        $commande->setEtat(0);
        
             $this->entityManager->beginTransaction();
             try {
                 $this->entityManager->persist($commande);
                 $platsGroupes = array_count_values($plat_id);
     
                 foreach ($platsGroupes as $platId => $quantitePlat) {
                     $plat = $this->entityManager->getRepository(Plat::class)->find($platId);
     
                     if (!$plat) {
                         throw new \Exception("Le plat avec l'ID $platId n'existe pas.");
                     }
     
                     $detail = new Detail();
                     $detail->setPlat($plat);
                     $detail->setQuantite($quantitePlat);
                     $detail->setTotal($plat->getPrix() * $quantitePlat);
                     $detail->setCommande($commande);
     
                     $this->entityManager->persist($detail);
                 }
     
                 $this->entityManager->flush();
                 $this->entityManager->commit(); 
                 $this->panierService->clearPanier();
     
                 $this->addFlash('success', 'Votre commande a été validée avec succès. <script> localStorage.setItem("panier", JSON.stringify([]));</script>');
             } catch (\Exception $e) {
                 $this->entityManager->rollback(); 
                 $this->addFlash('error', 'Une erreur est survenue lors de la validation de votre commande : ' . $e->getMessage());
                 return $this->redirectToRoute('app_panier');
             }
     
             return $this->redirectToRoute('app_index');
         }
     }