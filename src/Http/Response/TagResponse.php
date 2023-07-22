<?php

declare(strict_types=1);

namespace App\Http\Response;

use App\Entity\Tag;
use App\Helper\DateTime;
use JsonSerializable;

final class TagResponse implements JsonSerializable
{
    public function __construct(public readonly Tag $tag)
    {
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->tag->getId(),
            'type' => $this->tag->getType(),
            'name' => $this->tag->getName(),
            'resourceName' => $this->tag->getResourceName(),
            'createdAt' => DateTime::getString($this->tag->getCreatedAt()),
            'updatedAt' => DateTime::getString($this->tag->getUpdatedAt()),
        ];
    }
}
