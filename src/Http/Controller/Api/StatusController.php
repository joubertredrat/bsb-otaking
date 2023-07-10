<?php

declare(strict_types=1);

namespace App\Http\Controller\Api;

use App\Helper\DateTime;
use DateTimeImmutable;
use Fig\Http\Message\RequestMethodInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class StatusController extends ApiController
{
    #[Route(
        path: '/api/status',
        name: 'app_api_status_get',
        methods: [RequestMethodInterface::METHOD_GET],
    )]
    public function get(): JsonResponse
    {
        try {
            return $this->jsonOk([
                'status' => 'ok',
                'datetime' => DateTime::getString(new DateTimeImmutable('now')),
            ]);
        } catch (Throwable $e) {
            return $this->jsonErrorInternalServerError($e);
        }
    }
}
