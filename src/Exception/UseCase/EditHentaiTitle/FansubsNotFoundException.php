<?php

declare(strict_types=1);

namespace App\Exception\UseCase\EditHentaiTitle;

use InvalidArgumentException;

class FansubsNotFoundException extends InvalidArgumentException
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
