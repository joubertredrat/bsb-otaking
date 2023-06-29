<?php

declare(strict_types=1);

namespace App\Response;

use DateTimeInterface;

abstract class AbstractResponse
{
    const DATETIME_CANONICAL_FORMAT = 'Y-m-d H:i:s';

    public function datetime(?DateTimeInterface $datetime): ?string
    {
        if (!$datetime instanceof DateTimeInterface) {
            return null;
        }

        return $datetime->format(self::DATETIME_CANONICAL_FORMAT);
    }
}
