<?php

declare(strict_types=1);

namespace App\Dto;

class CreateTitle
{
    public function __construct(
        public readonly string $name,
        public readonly array $alternativeNames,
        public readonly string $type,
        public readonly string $language,
        public readonly int $episodes,
        public readonly string $statusDownload,
        public readonly string $statusView,
        public readonly array $fansubs,
        public readonly array $files,
        public readonly array $tags,
    ) {
    }
}
