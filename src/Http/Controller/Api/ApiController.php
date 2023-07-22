<?php

declare(strict_types=1);

namespace App\Http\Controller\Api;

use Fig\Http\Message\StatusCodeInterface;
use JsonSerializable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiController extends AbstractController
{
    public function jsonOk(JsonSerializable | array $data): JsonResponse
    {
        return $this->json($data, StatusCodeInterface::STATUS_OK);
    }

    public function jsonCreated(JsonSerializable | array $data): JsonResponse
    {
        return $this->json($data, StatusCodeInterface::STATUS_CREATED);
    }
}
