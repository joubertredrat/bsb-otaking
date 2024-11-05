<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TagRepository extends ServiceEntityRepository implements TagRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tag::class);
    }

    public function save(Tag $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Tag $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function get(int $id): ?Tag
    {
        return $this->find($id);
    }

    public function getByTypeName(string $type, string $name): ?Tag
    {
        return $this->findOneBy(['type' => $type, 'name' => $name]);
    }

    public function list(PaginationSQL $pagination, string $tagTypeName): array
    {
        $qb = $this
            ->createQueryBuilder('t')
            ->addOrderBy('t.type', 'ASC')
            ->addOrderBy('t.name', 'ASC')
            ->setMaxResults($pagination->getLimit())
            ->setFirstResult($pagination->getOffset())
        ;

        if ($tagTypeName) {
            $qb
                ->where($qb->expr()->like(
                    (string) $qb->expr()->concat('t.type', $qb->expr()->literal(':'), 't.name'),
                    ':tagTypeName',
                ))
                ->setParameter('tagTypeName', '%' . $tagTypeName . '%')
            ;
        }

        return $qb->getQuery()->getResult();
    }

    public function countAll(string $tagTypeName): int
    {
        $qb = $this
            ->createQueryBuilder('t')
            ->select('COUNT(t.id) AS total')
        ;

        if ($tagTypeName) {
            $qb
                ->where($qb->expr()->like(
                    (string) $qb->expr()->concat('t.type', $qb->expr()->literal(':'), 't.name'),
                    ':tagTypeName',
                ))
                ->setParameter('tagTypeName', '%' . $tagTypeName . '%')
            ;
        }

        return (int) $qb->getQuery()->getOneOrNullResult()['total'];
    }
}
