<?php

namespace App\Tests\Controller;

use App\DataFixtures\CatBreedFixtures;
use App\DataFixtures\DogBreedFixtures;
use App\DataFixtures\PetTypeFixtures;
use App\DataFixtures\UnknownBreedFixtures;
use App\Entity\PetType;
use App\Enum\PetTypeEnum;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BreedControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;

    /**
     * @throws Exception
     */
    public function setUp(): void{
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $loader = new Loader();
        $loader->addFixture(new UnknownBreedFixtures());
        $loader->addFixture(new PetTypeFixtures());
        $loader->addFixture(new CatBreedFixtures());
        $loader->addFixture(new DogBreedFixtures());
        $purger = new ORMPurger($this->manager);
        $executor = new ORMExecutor($this->manager, $purger);
        $executor->purge();
        $executor->execute($loader->getFixtures());
    }

    public function testGetDogPetType(): void
    {
        $dogPetType = $this->manager->getRepository(PetType::class)->findOneBy(['name' => PetTypeEnum::DOG->name]);
        $this->client->request('GET', "/breeds?pet_type_id={$dogPetType->getId()}&page=1");
        $this->assertResponseIsSuccessful();
        $responseContent = $this->client->getResponse()->getContent();
        $responseData = json_decode($responseContent, true);
        $this->assertNotEmpty($responseData, 'Response should not be empty');
    }

    public function testGetCatPetType(): void
    {
        $dogPetType = $this->manager->getRepository(PetType::class)->findOneBy(['name' => PetTypeEnum::CAT->name]);
        $this->client->request('GET', "/breeds?pet_type_id={$dogPetType->getId()}&page=1");
        $this->assertResponseIsSuccessful();
        $responseContent = $this->client->getResponse()->getContent();
        $responseData = json_decode($responseContent, true);
        $this->assertNotEmpty($responseData, 'Response should not be empty');
    }

}
