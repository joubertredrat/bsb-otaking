<?php

declare(strict_types=1);

namespace App\Repository;

use App\Dto\Pagination;

class PaginationSQL
{
    public function __construct(public readonly Pagination $pagination)
    {
    }

    public function getOffset(): int
    {
        return ($this->pagination->page - 1) * $this->pagination->itemsPerPage;
    }

    public function getLimit(): int
    {
        return $this->pagination->itemsPerPage;
    }
}
