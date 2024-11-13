<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\HentaiTitle;

interface HentaiTitleRepositoryInterface
{
    public function save(HentaiTitle $entity, bool $flush = false): void;

    public function remove(HentaiTitle $entity, bool $flush = false): void;

    public function get(int $id): ?HentaiTitle;

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
    ): array;

    public function countAll(
        string $searchCriteria,
        string $type,
        string $language,
        int $rating,
        string $statusDownload,
        string $statusView,
        int $fansubId,
        int $tagId,
    ): int;
}
