<?php

declare(strict_types=1);

namespace App\Http\Controller\Api;

use App\Http\Factory\HentaiTitleListResponseFactory;
use App\Http\Request\CreateHentaiTitleRequest;
use App\UseCase\CreateHentaiTitle;
use App\UseCase\ListHentaiTitles;
use Fig\Http\Message\RequestMethodInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class HentaiTitlesController extends ApiController
{
    public function __construct(
        protected CreateHentaiTitle $createHentaiTitle,
        protected ListHentaiTitles $listHentaiTitles,
    ) {
    }

    #[Route(
        path: '/api/hentai/titles',
        name: 'app_api_hentai_titles_list',
        methods: [RequestMethodInterface::METHOD_GET],
    )]
    public function list(): JsonResponse
    {
        try {
            $titles = $this->listHentaiTitles->execute();
            $response = HentaiTitleListResponseFactory::createFromUsecase($titles);
            return $this->jsonOk($response);
        } catch (Throwable $e) {
            return $this->jsonErrorInternalServerError($e);
        }
    }

    #[Route(
        path: '/api/hentai/titles',
        name: 'app_api_hentai_titles_create',
        methods: [RequestMethodInterface::METHOD_POST],
    )]
    public function create(CreateHentaiTitleRequest $request): JsonResponse
    {
        try {
            return $this->jsonCreated([]);
        } catch (Throwable $e) {
            return $this->jsonErrorInternalServerError($e);
        }
    }
}
