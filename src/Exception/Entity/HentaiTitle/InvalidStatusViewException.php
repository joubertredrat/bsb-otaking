<?php

declare(strict_types=1);

namespace App\Exception\Entity\HentaiTitle;

use InvalidArgumentException;

class InvalidStatusViewException extends InvalidArgumentException
{
    public static function create(string $type, array $available): self
    {
        return new self(sprintf(
            'Invalid status view got [ %s ], statuses view available [ %s ]',
            $type,
            implode(', ', $available),
        ));
    }
}
