<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\HttpFoundation\Request;


class Auth_LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login', methods: ['GET', 'POST'])]
    public function index(AuthenticationUtils $utils, CsrfTokenManagerInterface $csrfTokenManager, Request $request,) : Response
    {

        if ($this->getUser()) {
            $this->addFlash('error', 'Vous êtes déjà connecté.');
            return $this->redirectToRoute('app_index'); 
        }

        if ($request->isMethod('POST')) {
            $token = new CsrfToken('authenticate', $request->request->get('_csrf_token'));
            if (!$csrfTokenManager->isTokenValid($token)) {
                throw new \Exception('Jeton CSRF invalide.');
            }
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