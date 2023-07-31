<?php

declare(strict_types=1);

namespace App\Exception\Entity\HentaiTitle;

use InvalidArgumentException;

class InvalidRatingException extends InvalidArgumentException
{
    public static function create(int $ratingGot, int $ratingMin, int $ratingMax): self
    {
        return new self(sprintf(
            'Invalid rating got [ %d ], expected between [ %d ] and [ %d ]',
            $ratingGot,
            $ratingMin,
            $ratingMax,
        ));
    }
}
