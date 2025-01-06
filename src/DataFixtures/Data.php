<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Plat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class Data extends Fixture
{
    public function load(ObjectManager $manager): void
    {
      
        $categories = [
            ['libelle' => 'Pizza', 'image' => 'pizza_cat.jpg', 'active' => true],
            ['libelle' => 'Burger', 'image' => 'burger_cat.jpg', 'active' => true],
            ['libelle' => 'Wraps', 'image' => 'wrap_cat.jpg', 'active' => true],
            ['libelle' => 'Pasta', 'image' => 'pasta_cat.jpg', 'active' => true],
            ['libelle' => 'Sandwich', 'image' => 'sandwich_cat.jpg', 'active' => true],
            ['libelle' => 'Asian Food', 'image' => 'asian_food_cat.jpg', 'active' => true],
            ['libelle' => 'Salade', 'image' => 'salade_cat.jpg', 'active' => true],
            ['libelle' => 'Veggie', 'image' => 'veggie_cat.jpg', 'active' => true],
        ];


        $categorieEntities = [];
        foreach ($categories as $data) {
            $categorie = new Categorie();
            $categorie->setLibelle($data['libelle'])
                      ->setImage($data['image'])
                      ->setActive($data['active']);
            $manager->persist($categorie);
            $categorieEntities[] = $categorie;
        }

  
        $plats = [
            [
                'libelle' => 'District Burger',
                'description' => 'Burger avec bun\'s du boulanger, deux steaks de 80g, poitrine de porc fumée, cheddar, salade et oignons confits.',
                'prix' => 8.00,
                'image' => 'hamburger.jpg',
                'categorie_id' => 2,
                'active' => true,
            ],
            [
                'libelle' => 'Pizza Bianca',
                'description' => 'Une pizza fine et croustillante garnie de crème mascarpone légèrement citronnée et de tranches de saumon fumé.',
                'prix' => 14.00,
                'image' => 'pizza-salmon.png',
                'categorie_id' => 1,
                'active' => true,
            ],
            [
                'libelle' => 'Buffalo Chicken Wrap',
                'description' => 'Du bon filet de poulet mariné dans notre spécialité sucrée & épicée, enveloppé dans une tortilla blanche douce faite maison.',
                'prix' => 5.00,
                'image' => 'buffalo-chicken.webp',
                'categorie_id' => 3,
                'active' => true,
            ],
            [
                'libelle' => 'Cheeseburger',
                'description' => 'Burger composé d\'un bun\'s du boulanger, de salade, oignons rouges, pickles, tomate, d\'un steak, et de cheddar.',
                'prix' => 8.00,
                'image' => 'cheesburger.jpg',
                'categorie_id' => 2,
                'active' => true,
            ],
            [
                'libelle' => 'Spaghetti aux légumes',
                'description' => 'Un plat de spaghetti au pesto de basilic et légumes poêlés, très parfumé et rapide.',
                'prix' => 10.00,
                'image' => 'spaghetti-legumes.jpg',
                'categorie_id' => 4,
                'active' => true,
            ],
            [
                'libelle' => 'Salade César',
                'description' => 'Une délicieuse salade composée de filets de poulet grillés, croutons à l\'ail, et tomates cerises.',
                'prix' => 7.00,
                'image' => 'cesar_salad.jpg',
                'categorie_id' => 7,
                'active' => true,
            ],
            [
                'libelle' => 'Pizza Margherita',
                'description' => 'Une authentique pizza margarita avec mozzarella et basilic frais.',
                'prix' => 14.00,
                'image' => 'pizza-margherita.jpg',
                'categorie_id' => 1,
                'active' => true,
            ],
            [
                'libelle' => 'Lasagnes',
                'description' => 'Recette des lasagnes avec viande hachée et gratinée à l\'emmental.',
                'prix' => 12.00,
                'image' => 'lasagnes_viande.jpg',
                'categorie_id' => 8,
                'active' => true,
            ],
            [
                'libelle' => 'Tagliatelles au saumon',
                'description' => 'Tagliatelles au saumon frais et crème, un véritable régal!',
                'prix' => 12.00,
                'image' => 'tagliatelles_saumon.webp',
                'categorie_id' => 4,
                'active' => true,
            ],
        ];

       
        foreach ($plats as $data) {
            $plat = new Plat();
            $plat->setLibelle($data['libelle'])
                 ->setDescription($data['description'])
                 ->setPrix((float)$data['prix'])
                 ->setImage($data['image'])
                 ->setActive($data['active']);

           
            if (isset($categorieEntities[$data['categorie_id'] - 1])) {
                $categorie = $categorieEntities[$data['categorie_id'] - 1];
                $plat->setCategorie($categorie); 
            }

            $manager->persist($plat);
        }

        $manager->flush();
    }
}