<?php

namespace App\Repository;

use App\Entity\Breed;
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
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        if ($searchValue !== null) {
            $qb->andWhere('breeds.name LIKE :val')
                ->setParameter('val', '%' . $searchValue . '%');
        }

        if ($petTypeId !== null) {
            $qb->andWhere('breeds.pet_type = :typeId')
                ->setParameter('typeId', $petTypeId);
        }

        return $qb->getQuery()
            ->getResult();
    }

    public function countBreedsBy($filter): int{
        $qb = $this->createQueryBuilder('breeds')
            ->select('count(breeds.id)');
        foreach ($filter as $field => $value) {
            if($value){
                $qb->andWhere('breeds.' . $field . ' = :' . $field)
                    ->setParameter($field, $value);
            }
        }
        return (int) $qb->getQuery()->getSingleScalarResult();
    }

    //    public function findOneBySomeField($value): ?Breed
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
