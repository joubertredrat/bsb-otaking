<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\HentaiTitle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class HentaiTitleRepository extends ServiceEntityRepository implements HentaiTitleRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HentaiTitle::class);
    }

    public function save(HentaiTitle $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(HentaiTitle $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function get(int $id): ?HentaiTitle
    {
        return $this->find($id);
    }

    public function list(): array
    {
        return $this
            ->createQueryBuilder('t')
            ->orderBy('t.name', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
}
