<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Symfony\Component\HttpFoundation\Request;
use function Symfony\Component\Clock\now;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(Request $request): Response
    {

 $session = $request->getSession();
 

        if (!$session->has('Panier')) {
            $session->set('Panier', []);

            // dd($session->get('Panier'));
        } 

        // dd("test");

        // $session->set('test', [41, 42, 43, 48]);


        // $foo = $session->get('test');
        
        // $session->invalidate();

        $foo[] = 00;

        // $session->set('test', $foo);

        
        dd($request->getSession());
        // dd("test");

        

// Get the current time as a DatePoint instance
            $now = now();

            $currentDate = new \DateTimeImmutable();
            // dd( $currentDate->format('d-m-Y'));

            // dd($now);

        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }

    #[Route('/test_reset', name: 'app_test_reset')]
    public function reset(Request $request): Response
    { 

        $session = $request->getSession();
            $session->invalidate();

            return $this->redirectToRoute('app_test', [
               
            ]);
    }
}