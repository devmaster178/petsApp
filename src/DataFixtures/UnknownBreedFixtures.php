<?php
namespace App\DataFixtures;

use App\Entity\Breed;
use App\Service\BreedService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Psr\Log\LoggerInterface;

class UnknownBreedFixtures extends Fixture{

    public function __construct(private readonly LoggerInterface $logger){}
    public function load(ObjectManager $manager): void{
        $breed = new Breed();
        $breed->setName(BreedService::UNKNOWN);
        $breed->setIsDangerous(false);
        $manager->persist($breed);
        $manager->flush();
        $this->logger->info("unknown breed: " . json_encode($breed));
    }
}
