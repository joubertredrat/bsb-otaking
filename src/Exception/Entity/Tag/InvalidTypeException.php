<?php

declare(strict_types=1);

namespace App\Exception\Entity\Tag;

use InvalidArgumentException;

class InvalidTypeException extends InvalidArgumentException
{
    public static function create(string $type, array $available): self
    {
        return new self(sprintf(
            'Invalid type got [ %s ], types available [ %s ]',
            $type,
            implode(', ', $available),
        ));
    }
}
