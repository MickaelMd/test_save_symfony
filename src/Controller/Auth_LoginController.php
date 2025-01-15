<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class Auth_LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login', methods: ['GET', 'POST'])]
    public function index(AuthenticationUtils $utils): Response
    {

        if ($this->getUser()) {
            return $this->redirectToRoute('app_index'); 
        }

        $error = $utils->getLastAuthenticationError();
        $lastUsername = $utils->getLastUsername();


        return $this->render('auth_login/index.html.twig', [
            'error' => $error,
            'last_username' => $lastUsername
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
public function logout()
{

    throw new \Exception('This should never be reached!');
}
}

// https://symfony.com/doc/6.4/security.html#form-login