<?php

declare(strict_types=1);

namespace App\Exception\UseCase\CreateTag;

use RuntimeException;

class TagAlreadyExistsException extends RuntimeException
{
    public static function create(string $type, string $name): self
    {
        return new self(\sprintf(
            'Tag with type [ %s ] and name [ %s ] already exists',
            $type,
            $name
        ));
    }
}
