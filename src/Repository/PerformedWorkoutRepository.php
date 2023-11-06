<?php

namespace App\Repository;

use App\Entity\PerformedWorkout;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PerformedWorkout>
 *
 * @method PerformedWorkout|null find($id, $lockMode = null, $lockVersion = null)
 * @method PerformedWorkout|null findOneBy(array $criteria, array $orderBy = null)
 * @method PerformedWorkout[]    findAll()
 * @method PerformedWorkout[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PerformedWorkoutRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PerformedWorkout::class);
    }

//    /**
//     * @return PerformedWorkout[] Returns an array of PerformedWorkout objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PerformedWorkout
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
