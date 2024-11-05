<?php

declare(strict_types=1);

namespace App\Dto;

class ListTags
{
    public function __construct(
        public readonly Pagination $pagination,
        public readonly string $resourceName,
    ) {}
}
