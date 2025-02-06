<?php

namespace App\Controller;

use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface; 
use Doctrine\ORM\EntityManagerInterface;

class Auth_RegisterController extends AbstractController
{
    
    private UserPasswordHasherInterface $passwordHasher;
    private EntityManagerInterface $entityManager;

    public function __construct(
        UserPasswordHasherInterface $passwordHasher, 
        EntityManagerInterface $entityManager
    ) {
        $this->passwordHasher = $passwordHasher;
        $this->entityManager = $entityManager;
    }

    #[Route('/auth', name: 'app_auth')]
    public function index(Request $request): Response
    {

        if ($this->getUser()) {
            $this->addFlash('error', 'Vous êtes déjà connecté.');
            return $this->redirectToRoute('app_index'); 
        }

        $registrationForm = $this->createForm(RegistrationFormType::class);
        $registrationForm->handleRequest($request);
    
        if ($registrationForm->isSubmitted()) {
            if ($registrationForm->isValid()) {
                $user = $registrationForm->getData();

                $hashedPassword = $this->passwordHasher->hashPassword($user, $user->getPassword());
                $user->setPassword($hashedPassword);
                $user->setRoles(['ROLE_CLIENT']); 
                $this->entityManager->persist($user);
                $this->entityManager->flush();

                $this->addFlash('success', 'Votre compte a été créé, vous pouvez vous connecter.');
                return $this->redirectToRoute('app_login');
            }
    
            return $this->render('auth_register/index.html.twig', [
                'registrationForm' => $registrationForm->createView(),
            ])->setPublic()->setMaxAge(0);
        }
        
        return $this->render('auth_register/index.html.twig', [
            'registrationForm' => $registrationForm->createView(),
        ]);
    }
}