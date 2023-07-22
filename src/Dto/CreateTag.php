<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\Tag;
use App\Exception\Dto\CreateTag\InvalidArgumentsException;

class CreateTag
{
    public function __construct(
        public readonly string $type,
        public readonly string $name,
    ) {
        $errors = [];
        if (!Tag::isValidType($type)) {
            $errors[] = 'type';
        }

        if (!Tag::isValidName($name)) {
            $errors[] = 'name';
        }

        if ($errors) {
            throw InvalidArgumentsException::create($errors);
        }
    }
}
