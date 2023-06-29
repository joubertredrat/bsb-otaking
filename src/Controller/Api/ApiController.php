<?php

declare(strict_types=1);

namespace App\Controller\Api;

use Fig\Http\Message\StatusCodeInterface;
use JsonSerializable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Throwable;

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

    public function jsonErrorBadRequest(Throwable | array $error): JsonResponse
    {
        if ($error instanceof Throwable) {
            $error = $this->exceptionArray($error);
        }

        return $this->json($error, StatusCodeInterface::STATUS_BAD_REQUEST);
    }

    public function jsonErrorUnprocessableEntity(Throwable | array $error): JsonResponse
    {
        if ($error instanceof Throwable) {
            $error = $this->exceptionArray($error);
        }

        return $this->json($error, StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY);
    }

    public function jsonErrorInternalServerError(Throwable | array $error): JsonResponse
    {
        if ($error instanceof Throwable) {
            $error = $this->exceptionArray($error);
        }

        return $this->json($error, StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);
    }

    private function exceptionArray(Throwable $e): array
    {
        return ['error' => $e->getMessage()];
    }
}
