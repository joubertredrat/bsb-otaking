<?php

declare(strict_types=1);

namespace App\Exception\ValueObject\Total;

use InvalidArgumentException;

class InvalidTotalException extends InvalidArgumentException
{
    public static function create(int $total): self
    {
        return new self(sprintf('Invalid total [ %d ]', $total));
    }
}
