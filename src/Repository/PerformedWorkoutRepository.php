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

    public function save(PerformedWorkout $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return PerformedWorkout[] Returns an array of PerformedWorkout objects
     */
    public function findByWorkoutName($name): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.name = :val')
            ->setParameter('val', $name)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

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
