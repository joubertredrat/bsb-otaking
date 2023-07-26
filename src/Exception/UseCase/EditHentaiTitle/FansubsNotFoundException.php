<?php

declare(strict_types=1);

namespace App\Exception\UseCase\EditHentaiTitle;

use RuntimeException;

class FansubsNotFoundException extends RuntimeException
{
    public static function create(array $ids): self
    {
        return new self(
            \sprintf(
                'Fansubs with IDs not found: %s',
                \implode(', ', $ids),
            )
        );
    }
}
