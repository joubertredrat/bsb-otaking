<?php

declare(strict_types=1);

namespace App\Http\Controller\Api;

use App\Dto\CreateHentaiTitle as DtoCreateHentaiTitle;
use App\Dto\EditHentaiTitle as DtoEditHentaiTitle;
use App\Entity\HentaiTitle;
use App\Http\Factory\HentaiTitleListResponseFactory;
use App\Http\Request\CreateHentaiTitleRequest;
use App\Http\Request\UpdateHentaiTitleRequest;
use App\Http\Response\HentaiTitleResponse;
use App\Http\Response\ListResponse;
use App\UseCase\CreateHentaiTitle;
use App\UseCase\EditHentaiTitle;
use App\UseCase\GetHentaiTitle;
use App\UseCase\ListHentaiTitles;
use Fig\Http\Message\RequestMethodInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class HentaiTitlesController extends ApiController
{
    public function __construct(
        protected CreateHentaiTitle $createHentaiTitle,
        protected ListHentaiTitles $listHentaiTitles,
        protected GetHentaiTitle $getHentaiTitle,
        protected EditHentaiTitle $editHentaiTitle,
    ) {
    }

    #[Route(
        path: '/api/hentai/titles',
        name: 'app_api_hentai_titles_list',
        methods: [RequestMethodInterface::METHOD_GET],
    )]
    public function list(): JsonResponse
    {
        $hentaiTitles = $this->listHentaiTitles->execute();
        $response = HentaiTitleListResponseFactory::createFromUsecase($hentaiTitles);
        return $this->jsonOk($response);
    }

    #[Route(
        path: '/api/hentai/titles/types',
        name: 'app_api_hentai_titles_types',
        methods: [RequestMethodInterface::METHOD_GET],
    )]
    public function types(): JsonResponse
    {
        $response = new ListResponse(list: HentaiTitle::getTypesAvailable());
        return $this->jsonOk($response);
    }

    #[Route(
        path: '/api/hentai/titles/languages',
        name: 'app_api_hentai_titles_languages',
        methods: [RequestMethodInterface::METHOD_GET],
    )]
    public function languages(): JsonResponse
    {
        $response = new ListResponse(list: HentaiTitle::getLanguagesAvailable());
        return $this->jsonOk($response);
    }

    #[Route(
        path: '/api/hentai/titles/statuses-download',
        name: 'app_api_hentai_titles_statuses_download',
        methods: [RequestMethodInterface::METHOD_GET],
    )]
    public function statusesDownload(): JsonResponse
    {
        $response = new ListResponse(list: HentaiTitle::getStatusesDownloadAvailable());
        return $this->jsonOk($response);
    }

    #[Route(
        path: '/api/hentai/titles/statuses-view',
        name: 'app_api_hentai_titles_statuses_view',
        methods: [RequestMethodInterface::METHOD_GET],
    )]
    public function statusesView(): JsonResponse
    {
        $response = new ListResponse(list: HentaiTitle::getStatusesViewAvailable());
        return $this->jsonOk($response);
    }

    #[Route(
        path: '/api/hentai/titles',
        name: 'app_api_hentai_titles_create',
        methods: [RequestMethodInterface::METHOD_POST],
    )]
    public function create(CreateHentaiTitleRequest $request): JsonResponse
    {
        $dto = new DtoCreateHentaiTitle(
            name: $request->name,
            alternativeNames: $request->alternativeNames,
            type: $request->type,
            language: $request->language,
            episodes: $request->episodes,
            statusDownload: $request->statusDownload,
            statusView: $request->statusView,
            fansubs: $request->fansubs,
            tags: $request->tags,
            videoFiles: $request->videoFiles,
        );
        $hentaiTitle = $this->createHentaiTitle->execute($dto);
        $response = new HentaiTitleResponse($hentaiTitle);

        return $this->jsonCreated($response);
    }

    #[Route(
        path: '/api/hentai/titles/{id}',
        name: 'app_api_hentai_titles_get',
        requirements: ['id' => '\d+'],
        methods: [RequestMethodInterface::METHOD_GET],
    )]
    public function get(int $id): JsonResponse
    {
        $hentaiTitle = $this->getHentaiTitle->execute($id);
        $response = new HentaiTitleResponse($hentaiTitle);

        return $this->jsonOk($response);
    }

    #[Route(
        path: '/api/hentai/titles/{id}',
        name: 'app_api_hentai_titles_update',
        requirements: ['id' => '\d+'],
        methods: [RequestMethodInterface::METHOD_PUT],
    )]
    public function update(UpdateHentaiTitleRequest $request, int $id): JsonResponse
    {
        $dto = new DtoEditHentaiTitle(
            id: $id,
            name: $request->name,
            alternativeNames: $request->alternativeNames,
            type: $request->type,
            language: $request->language,
            episodes: $request->episodes,
            statusDownload: $request->statusDownload,
            statusView: $request->statusView,
            fansubs: $request->fansubs,
            tags: $request->tags,
            videoFiles: $request->videoFiles,
        );
        $hentaiTitle = $this->editHentaiTitle->execute($dto);
        $response = new HentaiTitleResponse($hentaiTitle);

        return $this->jsonOk($response);
    }
}
