<?php

namespace App\Repository;

use App\Entity\AuthenticationUser;
use App\Entity\Workout;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Workout>
 *
 * @method Workout|null find($id, $lockMode = null, $lockVersion = null)
 * @method Workout|null findOneBy(array $criteria, array $orderBy = null)
 * @method Workout[]    findAll()
 * @method Workout[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkoutRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Workout::class);
    }

    public function save(Workout $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Workout $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findById($id): Workout {
        return $this->getEntityManager()->getRepository(Workout::class)->find($id);
    }

    public function deleteById($id): void {
        $workout = $this->getEntityManager()->getRepository(Workout::class)->find($id);

        if ($workout) {
            $exercises = $workout->getExercises();
            foreach ($exercises as $exercise) {
                $workout->removeExercise($exercise);
            }

            $this->getEntityManager()->flush();
            $this->getEntityManager()->remove($workout);
            $this->getEntityManager()->flush();
        } else {
            echo "Entity not found!";
        }
    }

    /**
     * @param AuthenticationUser $user
     * @return Workout[]
     */
    public function findAllByUser(AuthenticationUser $user): array
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }
    public function deleteWorkoutById($id): void
    {
        $queryBuilder = $this->createQueryBuilder('w')->delete('workout_exercise')
            ->where('w.workout_id = :val')
            ->setParameter('val', $id);

        $queryBuilder->getQuery()->execute();

        $queryWorkoutBuilder = $this->createQueryBuilder('w')->delete('workout')
            ->where('w.id = :val')
            ->setParameter('val', $id);

        $queryWorkoutBuilder->getQuery()->execute();
    }

//    public function findOneBySomeField($value): ?Workout
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
