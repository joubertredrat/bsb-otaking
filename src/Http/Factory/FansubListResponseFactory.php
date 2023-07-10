<?php

declare(strict_types=1);

namespace App\Http\Factory;

use App\Entity\Fansub;
use App\Http\Response\FansubResponse;
use App\Http\Response\ListResponse;

class FansubListResponseFactory
{
    public static function createFromUsecase(array $data): ListResponse
    {
        $response = new ListResponse();

        foreach ($data as $item) {
            if ($item instanceof Fansub) {
                $response->add(new FansubResponse($item));
            }
        }

        return $response;
    }
}
