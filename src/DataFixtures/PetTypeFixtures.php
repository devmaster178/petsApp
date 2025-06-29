<?php
namespace App\DataFixtures;
use App\Entity\PetType;
use App\Enum\PetTypeEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Psr\Log\LoggerInterface;

class PetTypeFixtures extends Fixture{

    public function __construct(private readonly LoggerInterface $logger) {}

    public function load(ObjectManager $manager): void{
        $petTypeRepository = $manager->getRepository(PetType::class);
        $existingCount = $petTypeRepository->count([]);
        $this->logger->info("Pet Type count:{$existingCount}");
        if ($existingCount > 0) {
            return;
        }
        foreach (PetTypeEnum::cases() as $petType) {
            $label = $petType->getLabel();
            $petType = new PetType();
            $petType->setName($label);
            $manager->persist($petType);
        }
        $manager->flush();
    }
}
