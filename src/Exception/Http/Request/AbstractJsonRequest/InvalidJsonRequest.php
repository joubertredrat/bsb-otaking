<?php

declare(strict_types=1);

namespace App\Exception\Http\Request\AbstractJsonRequest;

use RuntimeException;

class InvalidJsonRequest extends RuntimeException
{
    public function __construct(protected readonly array $errors = [])
    {
        parent::__construct();
    }

    public static function dispatch(array $errors): self
    {
        return new self($errors);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
