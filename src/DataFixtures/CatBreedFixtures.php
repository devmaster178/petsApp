<?php

namespace App\DataFixtures;

use App\Entity\Breed;
use App\Entity\PetType;
use App\Enum\PetTypeEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CatBreedFixtures extends Fixture implements DependentFixtureInterface
{
    private $catBreeds = [
        'Abyssinian',
        'American Bobtail',
        'American Curl',
        'American Shorthair',
        'American Wirehair',
        'Balinese',
        'Bengal',
        'Birman',
        'Bombay',
        'British Shorthair',
        'Burmese',
        'Burmilla',
        'Chartreux',
        'Chausie',
        'Cornish Rex',
        'Devon Rex',
        'Egyptian Mau',
        'European Burmese',
        'Exotic Shorthair',
        'Havana Brown',
        'Himalayan',
        'Japanese Bobtail',
        'Korat',
        'LaPerm',
        'Maine Coon',
        'Manx',
        'Norwegian Forest Cat',
        'Ocicat',
        'Oriental',
        'Persian',
        'Ragdoll',
        'Russian Blue',
        'Scottish Fold',
        'Selkirk Rex',
        'Siamese',
        'Siberian',
        'Singapura',
        'Somali',
        'Sphynx',
        'Tonkinese',
        'Turkish Angora',
        'Turkish Van',
    ];

    public function __construct()
    {
    }

    public function load(ObjectManager $manager): void
    {
        $petTypeRepository = $manager->getRepository(PetType::class);
        $existingCatPetType = $petTypeRepository->findOneBy(['name' => PetTypeEnum::CAT->value]);
        if ($existingCatPetType) {
            $breedTypeRepository = $manager->getRepository(Breed::class);
            $existingBreedCount = $breedTypeRepository->count(['pet_type' => $existingCatPetType->getId()]);
            if ($existingBreedCount > 0) {
                return;
            }
            foreach ($this->catBreeds as $catBreed) {
                $breed = new Breed();
                $breed->setName($catBreed);
                $breed->setPetType($existingCatPetType);
                $manager->persist($breed);
            }
            $manager->flush();
        }
    }

    public function getDependencies(): array
    {
        return [PetTypeFixtures::class];
    }
}
