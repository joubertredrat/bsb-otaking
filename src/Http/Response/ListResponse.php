<?php

declare(strict_types=1);

namespace App\Http\Response;

use App\ValueObject\Total;
use JsonSerializable;

final class ListResponse implements JsonSerializable
{
    protected array $list = [];

    public function __construct(
        protected readonly Total $total,
    ) {
    }

    public function add(JsonSerializable $item): void
    {
        $this->list[] = $item;
    }

    public function jsonSerialize(): array
    {
        return [
            'total' => $this->total->value,
            'data' => $this->list,
        ];
    }
}
