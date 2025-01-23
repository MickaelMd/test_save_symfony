<?php

namespace App\DataFixtures;

use App\Entity\Utilisateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Dev_user extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $users = [
            [
                'email' => 'CompteClient@TestDev.com',
                'roles' => ['ROLE_CLIENT'],
                'password' => '$2y$13$i9GKJHukVM/p9sSOuY90M.CYeJOysGINIudX0Nm5HiH.hM9stNuF2',
                'nom' => 'Client',
                'prenom' => 'Client',
                'telephone' => '0707070707',
                'adresse' => '00 Rue Du Client',
                'cp' => '00000',
                'ville' => 'Client'
            ],
            [
                'email' => 'CompteChef@TestDev.com',
                'roles' => ['ROLE_CHEF'],
                'password' => '$2y$13$qAJHqNNjYSfUrQsDi6TQOeQnmTLL4fdPtFscmt59fB2YV20ZB0sYS',
                'nom' => 'Chef',
                'prenom' => 'Chef',
                'telephone' => '0707070707',
                'adresse' => '00 Rue Du Chef',
                'cp' => '00000',
                'ville' => 'Chef'
            ],
            [
                'email' => 'CompteAdmin@TestDev.com',
                'roles' => ['ROLE_ADMIN'],
                'password' => '$2y$13$s/LLEvM/ORM0FsQiPFORV.eC6bry6xtsXQPWjMJyuOCI6/6NP.P0G',
                'nom' => 'Admin',
                'prenom' => 'Root',
                'telephone' => '0707070707',
                'adresse' => '150 Rue de Admin',
                'cp' => '00000',
                'ville' => 'Admin'
            ]
        ];

        foreach ($users as $userData) {
            $user = new Utilisateur();
            $user->setEmail($userData['email']);
            $user->setRoles($userData['roles']);
            $user->setPassword($userData['password']);
            $user->setNom($userData['nom']);
            $user->setPrenom($userData['prenom']);
            $user->setTelephone($userData['telephone']);
            $user->setAdresse($userData['adresse']);
            $user->setCp($userData['cp']);
            $user->setVille($userData['ville']);

            $manager->persist($user);
        }

        $manager->flush();
    }
}