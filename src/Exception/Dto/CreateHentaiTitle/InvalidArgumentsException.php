<?php

declare(strict_types=1);

namespace App\Exception\Dto\CreateHentaiTitle;

use InvalidArgumentException;

class InvalidArgumentsException extends InvalidArgumentException
{
    public static function dispatch(array $arguments): self
    {
        return new self(
            \sprintf(
                'Invalid arguments got: %s',
                \implode(', ', $arguments),
            )
        );
    }
}
