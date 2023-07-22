<?php

declare(strict_types=1);

namespace App\Exception\Http\Request\AbstractJsonRequest;

use RuntimeException;

class InvalidJsonRequestException extends RuntimeException
{
    public function __construct(protected readonly array $errors = [])
    {
        parent::__construct();
    }

    public static function create(array $errors): self
    {
        return new self($errors);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
