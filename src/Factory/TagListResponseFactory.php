<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Tag;
use App\Response\ListResponse;
use App\Response\TagResponse;

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
