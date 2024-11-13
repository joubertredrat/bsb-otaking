<?php

declare(strict_types=1);

namespace App\Http\Factory;

use App\Entity\HentaiTitle;
use App\Http\Response\HentaiTitleResponse;
use App\Http\Response\ListResponse;
use App\ValueObject\PaginatedItems;

class HentaiTitleListResponseFactory
{
    public static function createFromUsecase(PaginatedItems $paginatedItems): ListResponse
    {
        $response = new ListResponse($paginatedItems->total);

        foreach ($paginatedItems->items as $item) {
            if ($item instanceof HentaiTitle) {
                $response->add(new HentaiTitleResponse($item));
            }
        }

        return $response;
    }
}
