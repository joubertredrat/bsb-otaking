<?php

declare(strict_types=1);

namespace App\Http\Response;

use JsonSerializable;

final class ListResponse implements JsonSerializable
{
    private array $list = [];

    public function add(JsonSerializable $item): void
    {
        $this->list[] = $item;
    }

    public function jsonSerialize(): array
    {
        return [
            'total' => count($this->list),
            'data' => $this->list,
        ];
    }
}
