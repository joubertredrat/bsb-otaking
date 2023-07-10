<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\HentaiTag;
use App\Response\HentaiTagResponse;
use App\Response\ListResponse;

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
