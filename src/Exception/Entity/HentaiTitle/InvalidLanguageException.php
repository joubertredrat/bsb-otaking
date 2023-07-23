<?php

declare(strict_types=1);

namespace App\Exception\Entity\HentaiTitle;

use InvalidArgumentException;

class InvalidLanguageException extends InvalidArgumentException
{
    public static function create(string $type, array $available): self
    {
        return new self(sprintf(
            'Invalid language got [ %s ], languages available [ %s ]',
            $type,
            implode(', ', $available),
        ));
    }
}
