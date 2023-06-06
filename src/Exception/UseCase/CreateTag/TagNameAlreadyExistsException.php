<?php

declare(strict_types=1);

namespace App\Exception\UseCase\CreateTag;

use RuntimeException;

class TagNameAlreadyExistsException extends RuntimeException
{
    public static function dispatch(string $name): self
    {
        return new self(
            \sprintf('Tag with name %s already exists', $name)
        );
    }
}
