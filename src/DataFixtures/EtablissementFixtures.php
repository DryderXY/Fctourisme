<?php

namespace App\DataFixtures;

use App\Entity\Etablissement;
use App\Entity\Ville;
use App\Repository\CategorieRepository;
use App\Repository\VilleRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\String\Slugger\SluggerInterface;

class EtablissementFixtures extends Fixture
{
    private SluggerInterface $slugger;
    private VilleRepository $villeRepository;
    private CategorieRepository $categorieRepository;

    public function __construct(SluggerInterface $slugger, VilleRepository $villeRepository, CategorieRepository $categorieRepository)
    {
        $this->slugger = $slugger;
        $this->villeRepository = $villeRepository;
        $this->categorieRepository = $categorieRepository;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("fr_FR");
        $totalVille = $this->villeRepository->findAll();
        $minVille = min($totalVille);
        $maxVille = max($totalVille);
        $totalCat = $this->categorieRepository->findAll();
        $mincat = min($totalCat);
        $maxcat= max($totalCat);

        for($i=0;$i<=50;$i++){
            $numVille = $faker->numberBetween($minVille->getId(),$maxVille->getId());
            $numcat = $faker->numberBetween($mincat->getId(),$maxcat->getId());
            $etablissement = new Etablissement();
            $etablissement->setNom($faker->word());
            $etablissement->setSlug($this->slugger->slug($etablissement->getNom())->lower());
            $etablissement->setDescription($faker->sentence(255,true));
            $etablissement->setTelephone(($faker->phoneNumber()));
            $etablissement->setEmail($faker->email());
            $etablissement->setActif($faker->numberBetween(0,1));
            $etablissement->setAccueil($faker->numberBetween(0,1));
            $etablissement->setVille($this->villeRepository->find($numVille));
            $etablissement->setAdresse($faker->address());
            $etablissement->setCreatedAt($faker->dateTimeBetween('-10 years'));
            $etablissement->addCategorie($this->categorieRepository->find($numcat));



            $manager->persist($etablissement);

        }


        $manager->flush();
    }
}
