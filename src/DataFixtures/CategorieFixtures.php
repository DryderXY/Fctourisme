<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategorieFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("fr_FR");

        for($i=0;$i<=10;$i++){
            $categorie = new Categorie();
            $categorie->setNom($faker->word());
            $categorie->setCreatedAt($faker->dateTimeBetween('-6 months'));
            $manager->persist($categorie);

        }

        $manager->flush();
    }
}
