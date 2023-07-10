<?php

declare(strict_types=1);

namespace App\Dto;

use App\Exception\Dto\CreateHentaiTag\InvalidNameException;

class CreateHentaiTag
{
    private const REGEX = '/^[\w]{1,}(:){1}[\w]{1,}/';

    public function __construct(
        public readonly string $name,
    ) {
        if (!preg_match_all(self::REGEX, $this->name)) {
            throw InvalidNameException::dispatch($this->name);
        }
    }
}
