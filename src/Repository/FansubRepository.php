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
class FansubRepository extends ServiceEntityRepository implements FansubRepositoryInterface
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
        return $this->find($id);
    }

    public function getByName(string $name): ?Fansub
    {
        return $this->findOneBy(['name' => $name]);
    }

    public function list(PaginationSQL $pagination, string $fansubName): array
    {
        $qb = $this
            ->createQueryBuilder('f')
            ->orderBy('f.name', 'ASC')
            ->setMaxResults($pagination->getLimit())
            ->setFirstResult($pagination->getOffset())
        ;
        if ($fansubName) {
            $qb
                ->where($qb->expr()->like('f.name', ':fansubName'))
                ->setParameter('fansubName', '%' . $fansubName . '%')
            ;
        }

        return $qb->getQuery()->getResult();
    }

    public function countAll(string $fansubName): int
    {
        $qb = $this
            ->createQueryBuilder('f')
            ->select('COUNT(f.id) AS total')
        ;
        if ($fansubName) {
            $qb
                ->where($qb->expr()->like('f.name', ':fansubName'))
                ->setParameter('fansubName', '%' . $fansubName . '%')
            ;
        }

        return (int) $qb->getQuery()->getOneOrNullResult()['total'];
    }
}
