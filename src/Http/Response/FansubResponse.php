<?php

declare(strict_types=1);

namespace App\Http\Response;

use App\Entity\Fansub;
use App\Helper\DateTime;
use JsonSerializable;

class FansubResponse implements JsonSerializable
{
    public function __construct(public readonly Fansub $fansub)
    {
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->fansub->getId(),
            'name' => $this->fansub->getName(),
            'createdAt' => DateTime::getString($this->fansub->getCreatedAt()),
            'updatedAt' => DateTime::getString($this->fansub->getUpdatedAt()),
        ];
    }
}
