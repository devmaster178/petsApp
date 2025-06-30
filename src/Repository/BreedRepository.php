<?php

namespace App\Repository;

use App\Entity\Breed;
use App\Service\BreedService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Breed>
 */
class BreedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Breed::class);
    }

    /**
     * @return Breed[] Returns an array of Breed objects
     */
    public function getBreeds($offset, $limit, $searchValue = null, $petTypeId = null): array
    {
        $qb = $this->createQueryBuilder('breeds')
            ->orderBy('breeds.id', 'ASC')
            ->setMaxResults($limit)
            ->setFirstResult($offset);

        if ($searchValue !== null) {
            $qb->andWhere('breeds.name LIKE :val')
                ->setParameter('val', '%' . $searchValue . '%');
        }

        if ($petTypeId !== null) {
            $qb->andWhere('breeds.pet_type = :typeId')
                ->setParameter('typeId', $petTypeId);
        }

        $qb->andWhere('breeds.name != :value')
            ->setParameter('value', BreedService::UNKNOWN);


        return $qb->getQuery()
            ->getResult();
    }

    /**
     * @param $filter
     * @return int
     */
    public function countBreedsBy($filter): int{
        $qb = $this->createQueryBuilder('breeds')
            ->select('count(breeds.id)')
            ->join('breeds.pet_type', 'pet_types');
        foreach ($filter as $field => $value) {
            if($value){
                if(trim($field) == "pet_type"){
                    $qb->andWhere('pet_types.id = :' . $field)
                        ->setParameter($field, $value);
                }else{
                    $qb->andWhere('breeds.'. $field .' LIKE :' . $field)
                        ->setParameter($field, '%' . $value . '%');
                }
            }
        }
        $qb->andWhere('breeds.name != :value')
            ->setParameter('value', BreedService::UNKNOWN);

        return (int) $qb->getQuery()->getSingleScalarResult();
    }
}
