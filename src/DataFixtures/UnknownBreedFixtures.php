<?php

namespace App\DataFixtures;

use App\Entity\Breed;
use App\Service\BreedService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UnknownBreedFixtures extends Fixture
{
    public function __construct()
    {
    }

    public function load(ObjectManager $manager): void
    {
        $breed = new Breed();
        $breed->setName(BreedService::UNKNOWN);
        $breed->setIsDangerous(false);
        $manager->persist($breed);
        $manager->flush();
    }
}
