<?php

declare(strict_types=1);

namespace App\Exception\UseCase\CreateTitle;

use RuntimeException;

class TagsNotFoundException extends RuntimeException
{
    public static function dispatch(array $ids): self
    {
        return new self(
            \sprintf(
                'Tags with IDs not found: %s',
                \implode(', ', $ids),
            )
        );
    }
}
