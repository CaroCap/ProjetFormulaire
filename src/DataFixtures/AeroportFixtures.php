<?php
namespace App\DataFixtures;

use App\Entity\Aeroport;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker;

class AeroportFixtures extends Fixture
{
    public function loadSansFake(ObjectManager $om)
    {
        // Création Aéroport sans le HYDRATE avec boucle pour en mettre pleins
        for ($i=0; $i < 10; $i++) { 
            $a1 = new Aeroport();
            $a1->setNom("Bruxelles Charleroi ".$i);
            $a1->setCode("CLR");
            $a1->setDateMisEnService(new \DateTime());
            $om->persist($a1);
        }
        $om->flush();
    }

    // AVEC FAKER
    public function load(ObjectManager $om)
    {
        $faker = Faker\Factory::create('fr_FR');
        // Création Aéroport sans le HYDRATE avec boucle pour en mettre pleins
        for ($i=0; $i < 10; $i++) { 
            $a1 = new Aeroport();
            $a1->setNom($faker->city()); // avec ou sans () c'est la même
            $a1->setCode($faker->postcode);
            $a1->setDateMisEnService(new \DateTime());
            $om->persist($a1);
        }
        $om->flush();
    }
}