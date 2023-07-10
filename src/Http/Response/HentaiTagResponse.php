<?php

declare(strict_types=1);

namespace App\Http\Response;

use App\Entity\HentaiTag;
use JsonSerializable;

final class HentaiTagResponse extends AbstractResponse implements JsonSerializable
{
    public function __construct(public readonly HentaiTag $hentaiTag)
    {
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->hentaiTag->getId(),
            'name' => $this->hentaiTag->getName(),
            'createdAt' => $this->datetime($this->hentaiTag->getCreatedAt()),
            'updatedAt' => $this->datetime($this->hentaiTag->getUpdatedAt()),
        ];
    }
}
