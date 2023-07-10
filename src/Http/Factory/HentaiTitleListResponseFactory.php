<?php

declare(strict_types=1);

namespace App\Http\Factory;

use App\Entity\HentaiTitle;
use App\Http\Response\HentaiTitleResponse;
use App\Http\Response\ListResponse;

class HentaiTitleListResponseFactory
{
    public static function createFromUsecase(array $data): ListResponse
    {
        $response = new ListResponse();

        foreach ($data as $item) {
            if ($item instanceof HentaiTitle) {
                $response->add(new HentaiTitleResponse($item));
            }
        }

        return $response;
    }
}
