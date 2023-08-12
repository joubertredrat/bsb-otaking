<?php

declare(strict_types=1);

namespace App\Exception\UseCase\EditHentaiTitle;

use InvalidArgumentException;

class TagsNotFoundException extends InvalidArgumentException
{
    public static function create(array $ids): self
    {
        return new self(
            \sprintf(
                'Tags with IDs not found: %s',
                \implode(', ', $ids),
            )
        );
    }
}
