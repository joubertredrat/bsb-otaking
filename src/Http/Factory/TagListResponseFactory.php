<?php

declare(strict_types=1);

namespace App\Http\Factory;

use App\Entity\Tag;
use App\Http\Response\ListResponse;
use App\Http\Response\TagResponse;
use App\ValueObject\PaginatedItems;

class TagListResponseFactory
{
    public static function createFromUsecase(PaginatedItems $paginatedItems): ListResponse
    {
        $response = new ListResponse($paginatedItems->total);

        foreach ($paginatedItems->items as $item) {
            if ($item instanceof Tag) {
                $response->add(new TagResponse($item));
            }
        }

        return $response;
    }
}
