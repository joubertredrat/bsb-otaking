<?php

declare(strict_types=1);

namespace App\Exception\UseCase\CreateHentaiTag;

use RuntimeException;

class HentaiTagNameAlreadyExistsException extends RuntimeException
{
    public static function dispatch(string $name): self
    {
        return new self(
            \sprintf('Hentai Tag with name %s already exists', $name)
        );
    }
}
