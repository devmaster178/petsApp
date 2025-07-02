<?php

namespace App\DataFixtures;

use App\Entity\PetType;
use App\Enum\PetTypeEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PetTypeFixtures extends Fixture
{
    public function __construct()
    {
    }

    public function load(ObjectManager $manager): void
    {
        foreach (PetTypeEnum::cases() as $petType) {
            $label = $petType->getLabel();
            $petType = new PetType();
            $petType->setName($label);
            $manager->persist($petType);
        }
        $manager->flush();
    }
}
