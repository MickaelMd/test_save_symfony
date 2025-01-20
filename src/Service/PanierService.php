<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\RequestStack;

class PanierService
{
    private $session;

    public function __construct(RequestStack $requestStack)
    {
        $this->session = $requestStack->getSession();
    }

    public function initializePanier(): void
    {
        if (!$this->session->has('Panier')) {
            $this->session->set('Panier', []);
        }

    }

    public function AddToPanier($id): void
    {
        $panier = $this->session->get('Panier', []); 
        $panier[] = $id;  
        $this->session->set('Panier', $panier);  
    }

    public function clearPanier(): void
    {
        
        $this->session->remove('Panier');
    }
    

    public function getSessionData()
    {
        return $this->session->all();
    }
}