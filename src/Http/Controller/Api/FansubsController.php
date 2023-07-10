<?php

declare(strict_types=1);

namespace App\Http\Controller\Api;

use App\Request\CreateFansubRequest;
use App\UseCase\CreateFansub;
use App\UseCase\ListFansubs;
use Fig\Http\Message\RequestMethodInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class FansubsController extends ApiController
{
    public function __construct(
        protected CreateFansub $createFansub,
        protected ListFansubs $listFansubs,
    ) {
    }

    #[Route(
        path: '/api/fansubs',
        name: 'app_api_list_fansubs',
        methods: [RequestMethodInterface::METHOD_GET],
    )]
    public function list(): JsonResponse
    {
        try {
            return $this->json([]);
        } catch (Throwable $e) {
            return $this->jsonErrorInternalServerError($e);
        }
    }

    #[Route(
        path: '/api/fansubs',
        name: 'app_api_create_fansub',
        methods: [RequestMethodInterface::METHOD_POST],
    )]
    public function create(CreateFansubRequest $request): JsonResponse
    {
        dd($request->name);
        try {
            return $this->jsonCreated(['data' => 'created']);
        } catch (Throwable $e) {
            return $this->jsonErrorInternalServerError($e);
        }
    }
}
