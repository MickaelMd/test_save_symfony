<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\RequestStack;

class PanierService
{
    private $session;

    public function __construct(RequestStack $requestStack)
    {
        //    $this->session = $requestStack->getSession();         // Probleme de session cli <----------------
        $this->session = $requestStack->getCurrentRequest() ? $requestStack->getSession() : null; // Solution <--

    }

    public function initializePanier(): void
    {
        if (!$this->session->has('Panier')) {
            $this->session->set('Panier', []);
        }
    }

    public function getPanier(): array
    {
        return $this->session->get('Panier', []);
    }

    public function getPanierCount(): int
    {
        return count($this->getPanier());
    }

    public function getPanierQuantites(): array
    {
    $panier = $this->getPanier(); 
    $quantites = array_count_values($panier); 

    return $quantites;
    }

    public function AddToPanier($id): void
    {
        $panier = $this->session->get('Panier', []); 
        $panier[] = $id;  
        $this->session->set('Panier', $panier);  
    }

    public function editPanier($id, $value)
    {
        $panier = $this->getPanierQuantites();
        
        if (isset($panier[$id])) {
            if ($value > 0) {
                $panier[$id] = $value; 
            } else {
                unset($panier[$id]); 
            }
        }
    
        $nouveauPanier = [];
        foreach ($panier as $platId => $quantite) {
            $nouveauPanier = array_merge($nouveauPanier, array_fill(0, $quantite, $platId));
        }
    
        $this->session->set('Panier', $nouveauPanier);
    }

    public function clearPanier(): void
    {
        
        $this->session->remove('Panier');
    }
    
    public function removePanier($id): void
    {
        $panier = $this->session->get('Panier', []);
        $panier = array_filter($panier, fn($item) => (string) $item !== (string) $id);
        $panier = array_values($panier);
    
        $this->session->set('Panier', $panier);
    }

    public function getSessionData()
    {
        return $this->session->all();
    }
}