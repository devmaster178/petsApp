<?php
namespace App\DataFixtures;

use App\Entity\Breed;
use App\Entity\PetType;
use App\Enum\PetTypeEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class DogBreedFixtures extends Fixture implements DependentFixtureInterface{

    private $_dogBreeds = [
        "Labrador Retriever",
        "German Shepherd",
        "Golden Retriever",
        "Bulldog",
        "Beagle",
        "Poodle",
        "Rottweiler",
        "Yorkshire Terrier",
        "Boxer",
        "Dachshund",
        "Siberian Husky",
        "Great Dane",
        "Doberman Pinscher",
        "Shih Tzu",
        "Australian Shepherd",
        "Chihuahua",
        "Pomeranian",
        "Border Collie",
        "Bernese Mountain Dog",
        "Cocker Spaniel",
        "Shetland Sheepdog",
        "Boston Terrier",
        "Pug",
        "Maltese",
        "Bichon Frise",
        "Saint Bernard",
        "Weimaraner",
        "Basset Hound",
        "English Mastiff",
        "Bull Terrier"
    ];
    public function load(ObjectManager $manager): void{
        $petTypeRepository = $manager->getRepository(PetType::class);
        $existingDogPetType = $petTypeRepository->findOneBy([ 'name' => PetTypeEnum::DOG->value ]);
        if ($existingDogPetType) {
            $breedTypeRepository = $manager->getRepository(Breed::class);
            $existingBreedCount = $breedTypeRepository->count([]);
            if ($existingBreedCount > 0) {
                return;
            }
            foreach ($this->_dogBreeds as $dogBreed) {
                $breed = new Breed();
                $breed->setName($dogBreed);
                $breed->setPetType($existingDogPetType);
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
