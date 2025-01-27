<?php

namespace App\EventSubscriber;

use App\Entity\Commande;
use Doctrine\ORM\Events;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Service\PanierService;
use App\Repository\PlatRepository;

class CommandeSubscriber implements EventSubscriberInterface
{
    private $panierService;
    private $platRepository;

    public function __construct(
        private MailerInterface $mailer,
        PanierService $panierService,
        PlatRepository $platRepository 
    ) {
        $this->panierService = $panierService;
        $this->platRepository = $platRepository; 
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::postPersist,
        ];
    }

    public function postPersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!$entity instanceof Commande) {
            return;
        }
        $commande_list = $this->panierService->getPanierQuantites();

        $plats = $this->platRepository->findBy(['id' => array_keys($commande_list)]);

        $platsAvecQuantites = [];
        $total = 0;

        foreach ($plats as $plat) {
            $quantite = $commande_list[$plat->getId()];
            $platsAvecQuantites[] = [
                'plat' => $plat,
                'quantite' => $quantite,
            ];
            $total += $plat->getPrix() * $quantite;
        }

        $utilisateur = $entity->getUtilisateur();

        $platsHtml = '';
        foreach ($platsAvecQuantites as $item) {
            $platsHtml .= sprintf(
                '<p>%s (x%d) - %.2f €</p>',
                $item['plat']->getLibelle(),
                $item['quantite'],
                $item['plat']->getPrix() * $item['quantite']
            );
        }

        $email = (new Email())
        ->from('Noreply@TheDistrict.com')
        ->to($utilisateur->getEmail())
        ->subject('Nouvelle commande The District')
        ->html(sprintf(
            '<h3>Bonjour %s %s,</h3>' .
            '<p>Votre commande numéro : %d a été créée.</p>' .
            '<h4>Voici les plats que vous avez commandés :</h4>' .
            '%s' .
            '<p>Total : %.2f €</p>' .
            '<h4>Elle sera envoyée à votre adresse :</h4>' .
            '<p>%s</p>' .
            '<p>%s %s</p>',
            $utilisateur->getNom(),
            $utilisateur->getPrenom(),
            $entity->getId(),
            $platsHtml,
            $total,
            $utilisateur->getAdresse(),
            $utilisateur->getCp(),
            $utilisateur->getVille()
        ));
    

        $this->mailer->send($email);
    }
}