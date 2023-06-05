<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Fansub;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Fansub>
 *
 * @method Fansub|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fansub|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fansub[]    findAll()
 * @method Fansub[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FansubRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fansub::class);
    }

    public function save(Fansub $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Fansub $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function get(int $id): ?Fansub
    {
        return $this->getEntityManager()->find(Fansub::class, $id);
    }

//    /**
//     * @return Fansub[] Returns an array of Fansub objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Fansub
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
