<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $message = new Contact();
            $data = $form->getData();
            $message = $data;
            $entityManager->persist($message);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_contact_success');
        }
    
        if ($form->isSubmitted() && !$form->isValid()) {
         
            return $this->redirectToRoute('app_contact_error');
        }
    
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    

    #[Route('/contact/success', name: 'app_contact_success')]
    public function success(): Response
    {
        return $this->render('contact/valide.html.twig');
    }

    #[Route('/contact/error', name: 'app_contact_error')]
    public function error(): Response
    {
        return $this->render('contact/error.html.twig');
    }
}