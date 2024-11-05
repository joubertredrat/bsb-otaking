<?php

declare(strict_types=1);

namespace App\ValueObject;

use App\Exception\ValueObject\Total\InvalidTotalException;

final class Total
{
    public function __construct(public readonly int $value)
    {
        if (!self::isValidTotal($value)) {
            throw InvalidTotalException::create($value);
        }
    }

    public static function isValidTotal(int $total): bool
    {
        return $total >= 0;
    }
}
