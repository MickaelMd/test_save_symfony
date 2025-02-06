<?php

namespace App\Controller;

use App\Form\ProfilType;
use App\Entity\Utilisateur;
use App\Form\ProfilEmailType;
use App\Form\ProfilPasswordType;
use App\Repository\DetailRepository;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;


class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function index(CommandeRepository $commandeRepository, DetailRepository $detailRepository): Response
    {
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            $this->addFlash('error', 'Vous devez être <a href="/login">connecté</a> pour accéder à votre Profil.');
            return $this->redirectToRoute('app_index');
        }
    
        $user = $this->getUser();
        /** @var \App\Entity\User|null $user */

        $id = $user->getId();
        $commandes = $commandeRepository->findBy(['utilisateur' => $id]);
        $commandesWithTotal = [];

        foreach ($commandes as $commande) {
            $details = $detailRepository->findBy(['commande' => $commande->getId()]);
            $total = 0;
            foreach ($details as $detail) {
                $total += $detail->getTotal();
            }
            $commandesWithTotal[] = [
                'commande' => $commande,
                'total' => $total,
            ];
        }

        $form = $this->createForm(ProfilType::class, $user);
        $form_password = $this->createForm(ProfilPasswordType::class);
        $form_email = $this->createForm(ProfilEmailType::class, $user);

        return $this->render('profil/index.html.twig', [
            'controller_name' => 'ProfilController',
            'user' => $user,
            'commandesWithTotal' => $commandesWithTotal,
            'form' => $form->createView(),
            'form_password' => $form_password->createView(),
            'form_email' => $form_email->createView(),
        ]);
    }

    #[Route('/update_profil', name: 'app_profil_update', methods: ['POST'])]
    public function updateProfil(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $hasher): Response
    {

    if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
        $this->addFlash('error', 'Vous devez être <a href="/login">connecté</a> pour accéder à votre Profil.');
        return $this->redirectToRoute('app_index');
    }

    $user = $this->getUser();
    if (!$user instanceof Utilisateur) {
        throw new \LogicException('L\'utilisateur n\'est pas une instance de Utilisateur.');
    }
    
    $form = $this->createForm(ProfilType::class, $user);
    $form->handleRequest($request);
    if ($form->isSubmitted()) {
        if ($form->isValid()) {
            
            $plainPassword = $form->get('password')->getData();
            if ($plainPassword && !$hasher->isPasswordValid($user, $plainPassword)) {

                $this->addFlash('error', 'Mot de passe incorrect.');
                return $this->redirectToRoute('app_profil'); 
            }

            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'Votre profil a été mis à jour.');
            return $this->redirectToRoute('app_profil');
        } else {
           $errors = $form->getErrors(true);
            foreach ($errors as $error) {
                $this->addFlash('error', $error->getMessage());
                return $this->redirectToRoute('app_profil');
            }
        }
    }}

#[Route('/update_profil_password', name: 'app_profil_password_update', methods: ['POST'])]
public function update_password_profil(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $hasher): Response
{
    if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
        $this->addFlash('error', 'Vous devez être <a href="/login">connecté</a> pour accéder à votre Profil.');
        return $this->redirectToRoute('app_index');
    }

    $user = $this->getUser();
    if (!$user instanceof Utilisateur) {
        throw new \LogicException('L\'utilisateur n\'est pas une instance de Utilisateur.');
    }

    $form = $this->createForm(ProfilPasswordType::class);
    $form->handleRequest($request);

    $plainPassword = $form->get('plainPassword')->getData(); 
    $newPassword = $form->get('newPassword')->getData(); 
    $newPassWordConfirm = $form->get('newPassword')->get('second')->getData();
    

    if ($newPassword != $newPassWordConfirm) {
        $this->addFlash('error', 'Les mots de passe ne sont pas identiques.');
        return $this->redirectToRoute('app_profil');
    }

    if ($plainPassword && !$hasher->isPasswordValid($user, $plainPassword)) {
        $this->addFlash('error', 'Mot de passe incorrect.');
        return $this->redirectToRoute('app_profil');
    }

    if ($form->isSubmitted()) {
        if ($form->isValid()) {

            if ($newPassword) {
                $hashedPassword = $hasher->hashPassword($user, $newPassword);
                $user->setPassword($hashedPassword);
            }

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Votre mot de passe a été mis à jour.');
            return $this->redirectToRoute('app_profil');
        } else {
            $this->addFlash('error', 'Le formulaire de mise a jour de mot de passe n\'est pas valide.');
        }
    }

    return $this->redirectToRoute('app_profil');
}

#[Route('/update_profil_email', name: 'app_profil_email_update', methods: ['POST'])]
public function update_email_profil(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $hasher): Response
{
    if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
        $this->addFlash('error', 'Vous devez être <a href="/login">connecté</a> pour accéder à votre Profil.');
        return $this->redirectToRoute('app_index');
    }

    $user = $this->getUser();
    if (!$user instanceof Utilisateur) {
        throw new \LogicException('L\'utilisateur n\'est pas une instance de Utilisateur.');
    }

    $form = $this->createForm(ProfilEmailType::class);
    $form->handleRequest($request);

    $plainPassword = $form->get('plainPassword')->getData(); 
    $newEmail = $form->get('email')->getData(); 
    
    
    if ($plainPassword && !$hasher->isPasswordValid($user, $plainPassword)) {
        $this->addFlash('error', 'Mot de passe incorrect.');
        return $this->redirectToRoute('app_profil');
    }

    if ($form->isSubmitted()) {
        if ($form->isValid()) {

            $user->setEmail($newEmail);
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Votre adresse email a bien été mise a jour.');
            return $this->redirectToRoute('app_profil');
        } else {
            $this->addFlash('error', 'Le formulaire de changement d\'e-mail n\'est pas valide.');
        }
    }

    return $this->redirectToRoute('app_profil');
}

// ------------------------------------

    #[Route('/delete_acount', name: 'app_profil_delete', methods: ['POST'])]
    public function delete_account(Request $request, CsrfTokenManagerInterface $csrfTokenManager, UserPasswordHasherInterface $hasher): Response
    {
        if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            $this->addFlash('error', 'Vous devez être <a href="/login">connecté</a> supprimer votre compte.');
            return $this->redirectToRoute('app_index');
        }

        $user = $this->getUser();
        if (!$user instanceof Utilisateur) {
            throw new \LogicException('L\'utilisateur n\'est pas une instance de Utilisateur.');
        }

        $token = new CsrfToken('tokken_delete_account', $request->request->get('_csrf_token'));
        if (!$csrfTokenManager->isTokenValid($token)) {
            $this->addFlash('error', 'Token CSRF invalide.');
            return $this->redirectToRoute('app_profil');
        }

        $plainPassword = $request->request->get('password');

        if ($plainPassword && !$hasher->isPasswordValid($user, $plainPassword)) {
            $this->addFlash('error', 'Mot de passe incorrect.');
            return $this->redirectToRoute('app_profil');
        }

        dd($plainPassword); 

        return $this->redirectToRoute('app_profil');
    }
}