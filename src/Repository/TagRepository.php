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

    public function list(): array
    {
        return $this
            ->createQueryBuilder('t')
            ->addOrderBy('t.type', 'ASC')
            ->addOrderBy('t.name', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
}
