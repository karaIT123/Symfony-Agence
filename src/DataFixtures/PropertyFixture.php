<?php

namespace App\DataFixtures;

use App\Entity\Property;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PropertyFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 100; $i++)
        {

            #$faker->words([3],[true]);
            $property = new Property();
            $property
                ->setTitle($faker->words(3,true))
                ->setDescription($faker->sentences(3,true))
                ->setSurface($faker->numberBetween(20,500))
                ->setRooms($faker->numberBetween(4,15))
                ->setBedrooms($faker->numberBetween(2,10))
                ->setFloor($faker->numberBetween(0,50))
                ->setPrice($faker->numberBetween(1000000,10000000))
                ->setHeat($faker->numberBetween(0, count(Property::HEAT) - 1))
                ->setCity($faker->city)
                ->setPostalCode($faker->postcode)
                ->setSold(false)
                ->setAddress($faker->address);
            $manager->persist($property);
            #$manager->flush();

        }
        $manager->flush();
    }
}
