<?php

namespace App\Service;

use App\Entity\Pet;
use App\Repository\PetRepository;
use App\Repository\PetTypeRepository;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Request;

class PetService{

    public function __construct(
        private readonly PetRepository $petRepository,
        private readonly PetTypeRepository $petTypeRepository,
    ){}


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
     * @param Request $request
     * @param Pet $pet
     * @return void
     */
    public function registerPet(Request $request, Pet $pet): void
    {
        $this->petRepository->save($pet,true);
    }

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
