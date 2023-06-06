<?php

declare(strict_types=1);

namespace App\Exception\Dto\CreateTag;

use InvalidArgumentException;

final class InvalidNameException extends InvalidArgumentException
{
    public static function dispatch(string $name): self
    {
        return new self(\sprintf('Invalid name got: %s', $name));
    }
}
