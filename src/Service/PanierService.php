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

    public function manageTestArray(): void
    {
    
    }

    public function getSessionData()
    {
        return $this->session->all();
    }
}