<?php

declare(strict_types=1);

namespace App\Http\Controller\Api;

use App\Dto\CreateFansub as DtoCreateFansub;
use App\Dto\ListFansubs as DtoListFansubs;
use App\Http\Factory\FansubListResponseFactory;
use App\Http\Factory\PaginationFactory;
use App\Http\Request\CreateFansubRequest;
use App\Http\Response\FansubResponse;
use App\UseCase\CreateFansub;
use App\UseCase\ListFansubs;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FansubsController extends ApiController
{
    public function __construct(
        protected CreateFansub $createFansub,
        protected ListFansubs $listFansubs,
    ) {
    }

    #[Route(
        path: '/api/fansubs',
        name: 'app_api_fansub_list',
        methods: [self::METHOD_GET],
    )]
    public function list(Request $request): JsonResponse
    {
        $pagination = PaginationFactory::createFromRequest($request);
        $dto = new DtoListFansubs(
            pagination: $pagination,
            fansubName: $request->get('fansubName', ''),
        );
        $fansubs = $this->listFansubs->execute($dto);
        $response = FansubListResponseFactory::createFromUsecase($fansubs);

        return $this->jsonOk($response);
    }

    #[Route(
        path: '/api/fansubs',
        name: 'app_api_fansub_create',
        methods: [self::METHOD_POST],
    )]
    public function create(CreateFansubRequest $request): JsonResponse
    {
        $dto = new DtoCreateFansub(name: $request->name);
        $fansub = $this->createFansub->execute($dto);
        $response = new FansubResponse($fansub);

        return $this->jsonCreated($response);
    }
}
