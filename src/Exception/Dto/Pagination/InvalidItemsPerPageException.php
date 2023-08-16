<?php

declare(strict_types=1);

namespace App\Exception\Dto\Pagination;

use InvalidArgumentException;

class InvalidItemsPerPageException extends InvalidArgumentException
{
    public static function create(int $itemsPerPage): self
    {
        return new self(
            \sprintf('Invalid items per page got: %d', $itemsPerPage)
        );
    }
}
