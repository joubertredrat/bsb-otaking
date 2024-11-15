<?php

declare(strict_types=1);

namespace App\Http\Controller\Api;

use App\Http\Controller\BaseController;
use JsonSerializable;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiController extends BaseController
{
    public function jsonOk(JsonSerializable | array $data): JsonResponse
    {
        return $this->json($data, self::STATUS_OK);
    }

    public function jsonCreated(JsonSerializable | array $data): JsonResponse
    {
        return $this->json($data, self::STATUS_CREATED);
    }
}
