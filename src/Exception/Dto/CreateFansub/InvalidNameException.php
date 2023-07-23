<?php

declare(strict_types=1);

namespace App\Exception\Dto\CreateFansub;

use InvalidArgumentException;

final class InvalidNameException extends InvalidArgumentException
{
    public static function create(string $name): self
    {
        return new self(\sprintf('Invalid name got: %s', $name));
    }
}
