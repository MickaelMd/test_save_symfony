<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface; 
use Doctrine\ORM\EntityManagerInterface;

class AuthController extends AbstractController
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
        $registrationForm = $this->createForm(RegistrationFormType::class);
        $registrationForm->handleRequest($request);
    
        if ($registrationForm->isSubmitted()) {
            if ($registrationForm->isValid()) {
                $user = $registrationForm->getData();
    
                $hashedPassword = $this->passwordHasher->hashPassword($user, $user->getPassword());
                $user->setPassword($hashedPassword);
    
                $this->entityManager->persist($user);
                $this->entityManager->flush();

                return $this->redirectToRoute('app_index');
            }
    
            return $this->render('auth/index.html.twig', [
                'registrationForm' => $registrationForm->createView(),
            ])->setPublic()->setMaxAge(0);
        }
    
        // Affiche le formulaire
        return $this->render('auth/index.html.twig', [
            'registrationForm' => $registrationForm->createView(),
        ]);
    }
}