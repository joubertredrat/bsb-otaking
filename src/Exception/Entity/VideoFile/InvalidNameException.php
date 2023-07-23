<?php

declare(strict_types=1);

namespace App\Exception\Entity\VideoFile;

use InvalidArgumentException;

class InvalidNameException extends InvalidArgumentException
{
    public static function create(string $name): self
    {
        return new self(sprintf('Invalid name got [ %s ]', $name));
    }
}
