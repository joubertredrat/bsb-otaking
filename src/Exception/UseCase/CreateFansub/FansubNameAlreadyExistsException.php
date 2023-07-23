<?php

declare(strict_types=1);

namespace App\Exception\UseCase\CreateFansub;

use RuntimeException;

class FansubNameAlreadyExistsException extends RuntimeException
{
    public static function create(string $name): self
    {
        return new self(
            \sprintf('Fansub with name %s already exists', $name)
        );
    }
}
