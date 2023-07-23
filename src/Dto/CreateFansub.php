<?php

declare(strict_types=1);

namespace App\Dto;

use App\Exception\Dto\CreateFansub\InvalidNameException;

class CreateFansub
{
    public function __construct(public readonly string $name)
    {
        if ($this->name === '') {
            throw InvalidNameException::create($this->name);
        }
    }
}
