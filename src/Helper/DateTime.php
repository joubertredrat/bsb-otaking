<?php

declare(strict_types=1);

namespace App\Helper;

use DateTimeInterface;

class DateTime
{
    private const CANONICAL_FORMAT = 'Y-m-d H:i:s';

    public static function getString(?DateTimeInterface $datetime): ?string
    {
        if (!$datetime instanceof DateTimeInterface) {
            return null;
        }

        return $datetime->format(self::CANONICAL_FORMAT);
    }
}
