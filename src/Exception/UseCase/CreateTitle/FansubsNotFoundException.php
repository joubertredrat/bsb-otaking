<?php

declare(strict_types=1);

namespace App\Exception\UseCase\CreateTitle;

use RuntimeException;

class FansubsNotFoundException extends RuntimeException
{
    public static function dispatch(array $ids): self
    {
        return new self(
            \sprintf(
                'Fansubs with IDs not found: %s',
                \implode(', ', $ids),
            )
        );
    }
}
