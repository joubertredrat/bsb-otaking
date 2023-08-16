<?php

declare(strict_types=1);

namespace App\Exception\Dto\Pagination;

use InvalidArgumentException;

class InvalidPageException extends InvalidArgumentException
{
    public static function create(int $page): self
    {
        return new self(
            \sprintf('Invalid page got: %d', $page)
        );
    }
}
