<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Categorie;
use App\Entity\Evenement;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class EvenementFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');
        for ($i = 1; $i <= 6; $i++) {
            $categorie = new Categorie;
            $categorie->setNomCategorie($faker->sentence());

            $manager->persist($categorie);
        }
        for ($j = 1; $j <= mt_rand(8, 10); $j++) {
            $evenement = new Evenement;

            $description = '<p>' . join('</p><p>', $faker->paragraphs(2)) . '</p>';

            $evenement->setNom($faker->sentence(3))
                ->setDescription($description)
                ->setImage("http://picsum.photos/250/150")
                ->setVille($faker->country())
                ->setDateDebut($faker->dateTimeBetween('-6 months'))
                ->setDateFin($faker->dateTimeBetween('now','+4 months'))
                ->setIdCategorie($categorie);

            $manager->persist($evenement);
        }
        $manager->flush();
    }
}
