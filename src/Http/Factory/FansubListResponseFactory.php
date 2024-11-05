<?php

declare(strict_types=1);

namespace App\Http\Factory;

use App\Entity\Fansub;
use App\Http\Response\FansubResponse;
use App\Http\Response\ListResponse;
use App\ValueObject\PaginatedItems;

class FansubListResponseFactory
{
    public static function createFromUsecase(PaginatedItems $paginatedItems): ListResponse
    {
        $response = new ListResponse($paginatedItems->total);

        foreach ($paginatedItems->items as $item) {
            if ($item instanceof Fansub) {
                $response->add(new FansubResponse($item));
            }
        }

        return $response;
    }
}
