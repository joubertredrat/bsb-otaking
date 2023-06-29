<?php

declare(strict_types=1);

namespace App\Response;

use App\Entity\Tag;
use JsonSerializable;

final class TagResponse extends AbstractResponse implements JsonSerializable
{
    public function __construct(public readonly Tag $tag)
    {
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->tag->getId(),
            'name' => $this->tag->getName(),
            'created_at' => $this->datetime($this->tag->getCreatedAt()),
            'updated_at' => $this->datetime($this->tag->getUpdatedAt()),
        ];
    }
}
