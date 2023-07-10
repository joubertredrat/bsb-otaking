<?php

declare(strict_types=1);

namespace App\Http\Response;

use App\Entity\Fansub;
use JsonSerializable;

class FansubResponse extends AbstractResponse implements JsonSerializable
{
    public function __construct(public readonly Fansub $fansub)
    {
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->fansub->getId(),
            'name' => $this->fansub->getName(),
            'createdAt' => $this->datetime($this->fansub->getCreatedAt()),
            'updatedAt' => $this->datetime($this->fansub->getUpdatedAt()),
        ];
    }
}
