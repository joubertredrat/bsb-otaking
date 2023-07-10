<?php

declare(strict_types=1);

namespace App\Http\Response;

use App\Entity\HentaiTag;
use App\Helper\DateTime;
use JsonSerializable;

final class HentaiTagResponse implements JsonSerializable
{
    public function __construct(public readonly HentaiTag $hentaiTag)
    {
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->hentaiTag->getId(),
            'name' => $this->hentaiTag->getName(),
            'createdAt' => DateTime::getString($this->hentaiTag->getCreatedAt()),
            'updatedAt' => DateTime::getString($this->hentaiTag->getUpdatedAt()),
        ];
    }
}
