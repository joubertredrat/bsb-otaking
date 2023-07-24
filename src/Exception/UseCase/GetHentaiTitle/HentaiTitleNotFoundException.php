<?php

declare(strict_types=1);

namespace App\Exception\UseCase\GetHentaiTitle;

use InvalidArgumentException;

class HentaiTitleNotFoundException extends InvalidArgumentException
{
    public static function create(int $id): self
    {
        return new self(sprintf('Hentai title not found by id [ %d ]', $id));
    }
}
