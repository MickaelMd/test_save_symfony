<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CategorieRepository;
use App\Repository\PlatRepository;
use App\Repository\CommandeRepository;
use App\Repository\UtilisateurRepository;
use App\Repository\DetailRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Csrf\CsrfToken;

class GestionController extends AbstractController
{
    #[Route('/gestion', name: 'app_gestion')]
    public function index(PlatRepository $platRepository, CategorieRepository $categorieRepository, CommandeRepository $commandeRepository, UtilisateurRepository $utilisateurRepository, DetailRepository $detailRepository) : Response
    {

        if (!$this->isGranted('ROLE_CHEF') && !$this->isGranted('ROLE_ADMIN')) {
            $this->addFlash('error', 'Vous n\'avez pas les droits pour accéder à cette page.');
            return $this->redirectToRoute('app_index');
        }
        
        $plats = $platRepository->findAll();
        $categories = $categorieRepository->findAll();
        $commandes = $commandeRepository->findAll();
        $user = $utilisateurRepository->findAll();
        $detail = $detailRepository->findAll();

        $detailsParCommande = [];
        foreach ($commandes as $commande) {
            $detailsParCommande[$commande->getId()] = $detailRepository->findBy(['commande' => $commande]);
        }

        return $this->render('gestion/index.html.twig', [
            'controller_name' => 'GestionController',
            'plats' => $plats,
            'categories' => $categories,
            'commandes' => $commandes,
            'user' => $user,
            'detailsParCommande' => $detailsParCommande,

        ]);
    }

    #[Route('/update-plat', name: 'update_plat', methods: ['POST'])]
public function updatePlat(Request $request, PlatRepository $platRepository, EntityManagerInterface $em, CsrfTokenManagerInterface $csrfTokenManager): Response
{
    if (!$this->isGranted('ROLE_CHEF') && !$this->isGranted('ROLE_ADMIN')) {
        $this->addFlash('error', 'Vous n\'avez pas les droits pour accéder à cette page.');
        return $this->redirectToRoute('app_index');
    }

    $token = new CsrfToken('update_plat', $request->request->get('_csrf_token'));
    if (!$csrfTokenManager->isTokenValid($token)) {
        $this->addFlash('error', 'Token CSRF invalide.');
        return $this->redirectToRoute('app_gestion');
    }

    $id = $request->request->get('id');
    $libelle = $request->request->get('libelle');
    $description = $request->request->get('description');
    $prix = $request->request->get('prix');
    $image = $request->request->get('image');
    $active = $request->request->get('active') === 'on';
    $file = $request->files->get('image_upload');

    $plat = $platRepository->find($id);

    if ($plat == null) {
        $this->addFlash('error', 'Plat non trouvé.');
        return $this->redirectToRoute('app_gestion');
    }

    if ($file instanceof UploadedFile) {
       
        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    
        if (!in_array($file->getMimeType(), $allowedMimeTypes)) {
            $this->addFlash('error', 'Le fichier téléchargé doit être une image (JPEG, PNG, GIF, WEBP).');
            return $this->redirectToRoute('app_gestion');
        }

        if ($file->getSize() > 1048576) {
            $this->addFlash('error', 'Le fichier ne doit pas dépasser 1 Mo.');
            return $this->redirectToRoute('app_gestion');
        }
    
        $filePath = "assets/img/food/" . $image;
    
        if (file_exists($filePath)) {
            $this->addFlash('error', 'Une image avec le même nom existe déjà.');
            return $this->redirectToRoute('app_gestion');
        } else {
            try {
                $file->move("assets/img/food/", $image);
            } catch (FileException $e) {
                $this->addFlash('error', 'Une erreur est survenue lors du téléchargement de l\'image.');
                return $this->redirectToRoute('app_gestion');
            }
        }
    }

    $plat->setLibelle($libelle);
    $plat->setDescription($description);
    $plat->setPrix($prix);
    $plat->setImage($image);
    $plat->setActive($active);

    $em->persist($plat);
    $em->flush();

    $this->addFlash('success', 'Plat modifié avec succès.');
    return $this->redirectToRoute('app_gestion');
}

#[Route('/update-commande-etat', name: 'update-commande-etat', methods: ['POST'])]
public function updateCommandeEtat(Request $request, EntityManagerInterface $em, CsrfTokenManagerInterface $csrfTokenManager, CommandeRepository $commandeRepository): Response
{

    if (!$this->isGranted('ROLE_CHEF') && !$this->isGranted('ROLE_ADMIN')) {
        $this->addFlash('error', 'Vous n\'avez pas les droits pour accéder à cette page.');
        return $this->redirectToRoute('app_index');
    }
    $token = new CsrfToken('update_commande_etat', $request->request->get('_csrf_token'));
    if (!$csrfTokenManager->isTokenValid($token)) {
        $this->addFlash('error', 'Token CSRF invalide.');
        return $this->redirectToRoute('app_gestion');
    }

    $id = $request->request->get('id');
    $commandes = $commandeRepository->FindBy(['id' => $id]);

    if (!$commandes) {
        $this->addFlash('error', 'Une erreur s\'est produite lors de la sélection de la commande.');
        return $this->redirectToRoute('app_gestion');
    }

   dd($request->request->all());

    // dd($request->getContent()); 
    // return $this->redirectToRoute('app_gestion');
}


}