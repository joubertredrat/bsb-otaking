<?php

declare(strict_types=1);

namespace App\Exception\Entity\HentaiTitle;

use InvalidArgumentException;

class InvalidEpisodesException extends InvalidArgumentException
{
    public static function create(int $episodes): self
    {
        return new self(sprintf('Invalid episodes got [ %s ]', $episodes));
    }
}
