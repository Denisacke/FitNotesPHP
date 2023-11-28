<?php

namespace App\Repository;

use App\Entity\PerformedExercise;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PerformedExercise>
 *
 * @method PerformedExercise|null find($id, $lockMode = null, $lockVersion = null)
 * @method PerformedExercise|null findOneBy(array $criteria, array $orderBy = null)
 * @method PerformedExercise[]    findAll()
 * @method PerformedExercise[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PerformedExerciseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PerformedExercise::class);
    }

//    /**
//     * @return PerformedExercises[] Returns an array of PerformedExercises objects
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

//    public function findOneBySomeField($value): ?PerformedExercises
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
