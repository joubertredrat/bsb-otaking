<?php

declare(strict_types=1);

namespace App\Http\Factory;

use App\Entity\HentaiTag;
use App\Http\Response\HentaiTagResponse;
use App\Http\Response\ListResponse;

class HentaiTagListResponseFactory
{
    public static function createFromUsecase(array $data): ListResponse
    {
        $response = new ListResponse();

        foreach ($data as $item) {
            if ($item instanceof HentaiTag) {
                $response->add(new HentaiTagResponse($item));
            }
        }

        return $response;
    }
}
