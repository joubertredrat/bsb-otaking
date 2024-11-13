<?php

declare(strict_types=1);

namespace App\Dto;

class ListHentaiTitles
{
    public function __construct(
        public readonly Pagination $pagination,
        public readonly string $searchCriteria,
        public readonly string $type,
        public readonly string $language,
        public readonly int $rating,
        public readonly string $statusDownload,
        public readonly string $statusView,
        public readonly int $fansubId,
        public readonly int $tagId,
    ) {}
}
