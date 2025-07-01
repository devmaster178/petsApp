<?php

namespace App\Tests\Controller;

use App\DataFixtures\CatBreedFixtures;
use App\DataFixtures\DogBreedFixtures;
use App\DataFixtures\PetTypeFixtures;
use App\DataFixtures\UnknownBreedFixtures;
use App\Entity\Breed;
use App\Entity\Pet;
use App\Entity\PetType;
use App\Enum\BreedChoiceEnum;
use App\Enum\GenderEnum;
use App\Enum\HasDobInformationEnum;
use App\Repository\PetRepository;
use App\Repository\PetTypeRepository;
use App\Service\PetService;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class PetControllerTest extends WebTestCase
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

    public function testIndex(): void
    {
        $this->client->request('GET', '/');
        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('#info-header','Tell us about your dog');
        self::assertPageTitleContains('Register Pet');
    }

    public function testSummary(): void{
        $this->client->request('GET', '/pet/summary');
        self::assertResponseIsSuccessful();
        self::assertPageTitleContains('Pets Summary');
    }

    /**
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testCalculateAgeValidAge()
    {
        $petRepository = $this->createMock(PetRepository::class);
        $petTypeRepository = $this->createMock(PetTypeRepository::class);

        $service = new class($petRepository, $petTypeRepository)  extends PetService {
            public function publicCalculateAge(string $dob) {
                return $this->calculateAge($dob);
            }
        };

        $dob = date('Y-m-d', strtotime('-25 years'));
        $age = $service->publicCalculateAge($dob);

        $this->assertIsInt($age);
        $this->assertEquals(25, $age);
    }

    /**
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testCalculateAgeInvalidAge()
    {
        $petRepository = $this->createMock(PetRepository::class);
        $petTypeRepository = $this->createMock(PetTypeRepository::class);

        $service = new class($petRepository, $petTypeRepository)  extends PetService {
            public function publicCalculateAge(string $dob) {
                return $this->calculateAge($dob);
            }
        };

        $age = $service->publicCalculateAge('invalid-date');

        $this->assertNull($age);
    }

    public function testSave(): void
    {
        $crawler = $this->client->request('GET', '/');
        $this->assertResponseIsSuccessful();

        $petType = $this->manager->getRepository(PetType::class)->findOneBy([]);
        $breed = $this->manager->getRepository(Breed::class)->findOneBy([]);

        $formData = [
            'pet_form[name]' => 'Test Pet',
            'pet_form[type]' => $petType->getId(),
            'pet_form[breed]' => $breed->getId(),
            'pet_form[has_dob_information]' => HasDobInformationEnum::YES->value,
            'pet_form[date_of_birth][month]' => '5',
            'pet_form[date_of_birth][day]' => '15',
            'pet_form[date_of_birth][year]' => '2020',
            'pet_form[breed_choice]' => BreedChoiceEnum::MIX->value,
            'pet_form[breed_other]' => 'Coolie,Pooding',
            'pet_form[sex]' => GenderEnum::MALE->value,
            'pet_form[age]' => '18',
        ];

        $form = $crawler->selectButton('Continue')->form();
        $this->client->submit($form, $formData);

        if ($this->client->getResponse()->getStatusCode() !== 302) {
            echo $this->client->getResponse()->getContent();
        }

        $this->assertResponseRedirects('/pet/summary');
        $this->client->followRedirect();
        $this->assertResponseIsSuccessful();

        $this->assertSame(1, $this->manager->getRepository(Pet::class)->count([]));
    }
}
