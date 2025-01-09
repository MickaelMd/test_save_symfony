<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MentionsLegalesController extends AbstractController
{
    #[Route('/mentions-legales', name: 'app_mentions_legales')]
    public function index(): Response
    {
        return $this->render('mentions_legales/index.html.twig', [
            'controller_name' => 'MentionsLegalesController',
        ]);
    }

    #[Route('/pdc', name: 'app_politique_de_confidentialite')]
    public function pdc(): Response
    {
        return $this->render('mentions_legales/pdc.html.twig', [
            'controller_name' => 'PolitiqueDeConfidentialiteController',
        ]);
    }


    #[Route('/cgv', name: 'app_cgv')]
    public function cgv(): Response
    {
        return $this->render('mentions_legales/cgv.html.twig', [
            'controller_name' => 'PolitiqueDeConfidentialiteController',
        ]);
    }


}