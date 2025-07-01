<?php

namespace App\Service;

use App\Entity\Pet;
use App\Repository\PetRepository;
use App\Repository\PetTypeRepository;
use DateTime;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;

class PetService{

    public function __construct(
        private readonly PetRepository $petRepository,
        private readonly PetTypeRepository $petTypeRepository,
    ){}

    /**
     * @param string $dob
     * @return int|string|null
     */
    protected function calculateAge(string $dob): int|string|null {
        try {
            $birthDate = new DateTime($dob);
            $currentDate = new DateTime();
        } catch (\Exception $e) {
            return null;
        }
        $interval = $birthDate->diff($currentDate);
        return $interval->y;
    }

    /**
     * @return array
     */
    public function summary(): array
    {
        $petTypes = array_map(fn($pt) => [
            'id' => $pt->getId(),
            'name' => $pt->getName(),
        ], $this->petTypeRepository->findAll());
        return [
            'petTypes' => $petTypes
        ];
    }


    /**
     * @param Pet $pet
     * @return void
     */
    public function save(Pet $pet): void
    {
        $dob = $pet->getDateOfBirth();
        if($dob){
            $age = $this->calculateAge($dob->format('Y-m-d'));
            if($age){
                $pet->setAge($age);
            }
        }
        $this->petRepository->save($pet,true);
    }

    /**
     * @param $currentPage
     * @param $itemsPerPage
     * @param $searchQuery
     * @param $selectedPetType
     * @return Pagerfanta
     */
    public function getPets($currentPage, $itemsPerPage, $searchQuery, $selectedPetType,): Pagerfanta
    {
        $queryBuilder = $this->petRepository->createQueryBuilder('p');

        if ($searchQuery) {
            $queryBuilder
                ->andWhere('p.name LIKE :search')
                ->setParameter('search', '%' . $searchQuery . '%');
        }

        if($selectedPetType){
            $queryBuilder
                ->andWhere('p.type = :petType')
                ->setParameter('petType', $selectedPetType);
        }

        return Pagerfanta::createForCurrentPageWithMaxPerPage(
            new QueryAdapter($queryBuilder),
            $currentPage,
            $itemsPerPage
        );
    }

}
