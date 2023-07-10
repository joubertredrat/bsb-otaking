<?php

declare(strict_types=1);

namespace App\Http\Controller\Api;

use App\Dto\CreateFansub as DtoCreateFansub;
use App\Exception\UseCase\CreateFansub\FansubNameAlreadyExistsException;
use App\Http\Factory\FansubListResponseFactory;
use App\Http\Request\CreateFansubRequest;
use App\Http\Response\FansubResponse;
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
        name: 'app_api_fansub_list',
        methods: [RequestMethodInterface::METHOD_GET],
    )]
    public function list(): JsonResponse
    {
        try {
            $fansubs = $this->listFansubs->execute();
            $response = FansubListResponseFactory::createFromUsecase($fansubs);
            return $this->jsonOk($response);
        } catch (Throwable $e) {
            return $this->jsonErrorInternalServerError($e);
        }
    }

    #[Route(
        path: '/api/fansubs',
        name: 'app_api_fansub_create',
        methods: [RequestMethodInterface::METHOD_POST],
    )]
    public function create(CreateFansubRequest $request): JsonResponse
    {
        try {
            $dto = new DtoCreateFansub(name: $request->name);
            $fansub = $this->createFansub->execute($dto);
            $response = new FansubResponse($fansub);

            return $this->jsonCreated($response);
        } catch (FansubNameAlreadyExistsException $e) {
            return $this->jsonErrorUnprocessableEntity($e);
        } catch (Throwable $e) {
            return $this->jsonErrorInternalServerError($e);
        }
    }
}
