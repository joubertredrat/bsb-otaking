<?php

declare(strict_types=1);

namespace App\Http\Controller\Api;

use App\Helper\DateTime;
use DateTimeImmutable;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class StatusController extends ApiController
{
    #[Route(
        path: '/api/status',
        name: 'app_api_status_get',
        methods: [self::METHOD_GET],
    )]
    public function get(): JsonResponse
    {
        return $this->jsonOk([
            'status' => 'ok',
            'datetime' => DateTime::getString(new DateTimeImmutable('now')),
        ]);
    }
}
