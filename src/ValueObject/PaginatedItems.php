<?php

declare(strict_types=1);

namespace App\ValueObject;

class PaginatedItems
{
    public function __construct(
        public readonly array $items,
        public readonly Total $total,
    ) {
    }
}
