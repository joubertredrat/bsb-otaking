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

    public function list(
        PaginationSQL $pagination,
        string $searchCriteria,
        string $type,
        string $language,
        int $rating,
        string $statusDownload,
        string $statusView,
        int $fansubId,
        int $tagId,
    ): array {
        $qb = $this
            ->createQueryBuilder('h')
            ->orderBy('h.name', 'ASC')
            ->setMaxResults($pagination->getLimit())
            ->setFirstResult($pagination->getOffset())
        ;

        if ($searchCriteria) {
            $qb
                ->join('h.videoFiles', 'v')
                ->andWhere($qb->expr()->orX(
                    $qb->expr()->like('h.name', ':searchCriteria'),
                    $qb->expr()->like('h.alternativeNames', ':searchCriteria'),
                    $qb->expr()->like('v.name', ':searchCriteria'),
                ))
                ->setParameter('searchCriteria', '%' . $searchCriteria . '%')
            ;
        }
        if (HentaiTitle::isValidType($type)) {
            $qb
                ->andWhere($qb->expr()->eq('h.type', ':type'))
                ->setParameter('type', $type)
            ;
        }
        if (HentaiTitle::isValidLanguage($language)) {
            $qb
                ->andWhere($qb->expr()->eq('h.language', ':language'))
                ->setParameter('language', $language)
            ;
        }
        if (HentaiTitle::isValidRating($rating)) {
            $qb
                ->andWhere($qb->expr()->eq('h.rating', ':rating'))
                ->setParameter('rating', $rating)
            ;
        }
        if (HentaiTitle::isValidStatusDownload($statusDownload)) {
            $qb
                ->andWhere($qb->expr()->eq('h.statusDownload', ':statusDownload'))
                ->setParameter('statusDownload', $statusDownload)
            ;
        }
        if (HentaiTitle::isValidStatusView($statusView)) {
            $qb
                ->andWhere($qb->expr()->eq('h.statusView', ':statusView'))
                ->setParameter('statusView', $statusView)
            ;
        }
        if ($fansubId > 0) {
            $qb
                ->join('h.fansubs', 'f')
                ->andWhere($qb->expr()->eq('f.id', ':fansubId'))
                ->setParameter('fansubId', $fansubId)
            ;
        }
        if ($tagId > 0) {
            $qb
                ->join('h.tags', 't')
                ->andWhere($qb->expr()->eq('t.id', ':tagId'))
                ->setParameter('tagId', $tagId)
            ;
        }

        return $qb->getQuery()->getResult();
    }

    public function countAll(
        string $searchCriteria,
        string $type,
        string $language,
        int $rating,
        string $statusDownload,
        string $statusView,
        int $fansubId,
        int $tagId,
    ): int {
        $qb = $this
            ->createQueryBuilder('h')
            ->select('COUNT(h.id) AS total')
        ;

        if ($searchCriteria) {
            $qb
                ->join('h.videoFiles', 'v')
                ->andWhere($qb->expr()->orX(
                    $qb->expr()->like('h.name', ':searchCriteria'),
                    $qb->expr()->like('h.alternativeNames', ':searchCriteria'),
                    $qb->expr()->like('v.name', ':searchCriteria'),
                ))
                ->setParameter('searchCriteria', '%' . $searchCriteria . '%')
            ;
        }
        if (HentaiTitle::isValidType($type)) {
            $qb
                ->andWhere($qb->expr()->eq('h.type', ':type'))
                ->setParameter('type', $type)
            ;
        }
        if (HentaiTitle::isValidLanguage($language)) {
            $qb
                ->andWhere($qb->expr()->eq('h.language', ':language'))
                ->setParameter('language', $language)
            ;
        }
        if (HentaiTitle::isValidRating($rating)) {
            $qb
                ->andWhere($qb->expr()->eq('h.rating', ':rating'))
                ->setParameter('rating', $rating)
            ;
        }
        if (HentaiTitle::isValidStatusDownload($statusDownload)) {
            $qb
                ->andWhere($qb->expr()->eq('h.statusDownload', ':statusDownload'))
                ->setParameter('statusDownload', $statusDownload)
            ;
        }
        if (HentaiTitle::isValidStatusView($statusView)) {
            $qb
                ->andWhere($qb->expr()->eq('h.statusView', ':statusView'))
                ->setParameter('statusView', $statusView)
            ;
        }
        if ($fansubId > 0) {
            $qb
                ->join('h.fansubs', 'f')
                ->andWhere($qb->expr()->eq('f.id', ':fansubId'))
                ->setParameter('fansubId', $fansubId)
            ;
        }
        if ($tagId > 0) {
            $qb
                ->join('h.tags', 't')
                ->andWhere($qb->expr()->eq('t.id', ':tagId'))
                ->setParameter('tagId', $tagId)
            ;
        }

        return (int) $qb->getQuery()->getOneOrNullResult()['total'];
    }
}
