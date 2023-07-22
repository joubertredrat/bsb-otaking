<?php

declare(strict_types=1);

namespace App\Http\Factory;

use App\Entity\Tag;
use App\Http\Response\ListResponse;
use App\Http\Response\TagResponse;

class TagListResponseFactory
{
    public static function createFromUsecase(array $data): ListResponse
    {
        $response = new ListResponse();

        foreach ($data as $item) {
            if ($item instanceof Tag) {
                $response->add(new TagResponse($item));
            }
        }

        return $response;
    }
}
