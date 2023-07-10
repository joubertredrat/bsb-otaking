<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\HentaiTag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class HentaiTagRepository extends ServiceEntityRepository implements HentaiTagRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HentaiTag::class);
    }

    public function save(HentaiTag $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(HentaiTag $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function get(int $id): ?HentaiTag
    {
        return $this->find($id);
    }

    public function getByName(string $name): ?HentaiTag
    {
        return $this->findOneBy(['name' => $name]);
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
