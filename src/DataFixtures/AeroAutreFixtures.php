<?php
namespace App\DataFixtures;

use Faker;
use App\Entity\Aeroport;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AeroAutreFixtures extends Fixture implements DependentFixtureInterface
{
    // AVEC FAKER
    public function load(ObjectManager $om) 
    {
        $faker = Faker\Factory::create('es_ES'); // on peut préciser la langue des données
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

    public function getDependencies()
    {
        return([AeroportFixtures::class // ::class pour remplacer 'APP\DataFictures\AeroportFixtures'
            ]);
    }
}