<?php

declare(strict_types=1);

namespace App\Exception\Entity\PrimaryKey;

use InvalidArgumentException;

class InvalidPrimaryKeyException extends InvalidArgumentException
{
    public static function create(int $id): self
    {
        return new self(sprintf('Invalid primary key got [ %s ]', $id));
    }
}
