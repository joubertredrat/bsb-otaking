<?php

declare(strict_types=1);

namespace App\Exception\Entity\HentaiTitle;

use InvalidArgumentException;

class InvalidStatusDownloadException extends InvalidArgumentException
{
    public static function create(string $type, array $available): self
    {
        return new self(sprintf(
            'Invalid status download got [ %s ], statuses download available [ %s ]',
            $type,
            implode(', ', $available),
        ));
    }
}
