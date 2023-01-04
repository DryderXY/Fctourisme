<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("fr_FR");
    for ($i=0;$i<20;$i++){


        $user = new User();
        $user->setPrenom($faker->name);
        $user->setNom($faker->lastName);
        $user->setPseudo($faker->userName);
        $user->setEmail($faker->email);
        $user->setActif($faker->numberBetween(0,1));
        $user->setCreatedAt($faker->dateTimeBetween('-6 months'));
        $user->setPassword(password_hash("gaheriet",PASSWORD_BCRYPT));
        $user->setRoles(["ROLE_USER"]);
        $manager->persist($user);
    }
        $manager->flush();
    }
}
