<?php

declare(strict_types=1);

namespace App\Http\Controller\Api;

use App\Dto\CreateHentaiTitle as DtoCreateHentaiTitle;
use App\Dto\EditHentaiTitle as DtoEditHentaiTitle;
use App\Dto\ListHentaiTitles as DtoListHentaiTitles;
use App\Entity\HentaiTitle;
use App\Http\Factory\HentaiTitleListResponseFactory;
use App\Http\Factory\PaginationFactory;
use App\Http\Request\CreateHentaiTitleRequest;
use App\Http\Request\UpdateHentaiTitleRequest;
use App\Http\Response\HentaiTitleResponse;
use App\UseCase\CreateHentaiTitle;
use App\UseCase\EditHentaiTitle;
use App\UseCase\GetHentaiTitle;
use App\UseCase\ListHentaiTitles;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

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
        methods: [self::METHOD_GET],
    )]
    public function list(Request $request): JsonResponse
    {
        $pagination = PaginationFactory::createFromRequest($request);
        $dto = new DtoListHentaiTitles(
            pagination: $pagination,
            searchCriteria: $request->get('searchCriteria', ''),
            type: $request->get('type', ''),
            language: $request->get('language', ''),
            rating: (int) $request->get('rating', -1),
            statusDownload: $request->get('statusDownload', ''),
            statusView: $request->get('statusView', ''),
            fansubId: (int) $request->get('fansubId', 0),
            tagId: (int) $request->get('tagId', 0),
        );
        $hentaiTitles = $this->listHentaiTitles->execute($dto);
        $response = HentaiTitleListResponseFactory::createFromUsecase($hentaiTitles);
        return $this->jsonOk($response);
    }

    #[Route(
        path: '/api/hentai/titles/types',
        name: 'app_api_hentai_titles_types',
        methods: [self::METHOD_GET],
    )]
    public function types(): JsonResponse
    {
        return $this->jsonOk(['data' => HentaiTitle::getTypesAvailable()]);
    }

    #[Route(
        path: '/api/hentai/titles/languages',
        name: 'app_api_hentai_titles_languages',
        methods: [self::METHOD_GET],
    )]
    public function languages(): JsonResponse
    {
        return $this->jsonOk(['data' => HentaiTitle::getLanguagesAvailable()]);
    }

    #[Route(
        path: '/api/hentai/titles/statuses-download',
        name: 'app_api_hentai_titles_statuses_download',
        methods: [self::METHOD_GET],
    )]
    public function statusesDownload(): JsonResponse
    {
        return $this->jsonOk(['data' => HentaiTitle::getStatusesDownloadAvailable()]);
    }

    #[Route(
        path: '/api/hentai/titles/statuses-view',
        name: 'app_api_hentai_titles_statuses_view',
        methods: [self::METHOD_GET],
    )]
    public function statusesView(): JsonResponse
    {
        return $this->jsonOk(['data' => HentaiTitle::getStatusesViewAvailable()]);
    }

    #[Route(
        path: '/api/hentai/titles',
        name: 'app_api_hentai_titles_create',
        methods: [self::METHOD_POST],
    )]
    public function create(CreateHentaiTitleRequest $request): JsonResponse
    {
        $dto = new DtoCreateHentaiTitle(
            name: $request->name,
            alternativeNames: $request->alternativeNames,
            type: $request->type,
            language: $request->language,
            episodes: $request->episodes,
            rating: $request->rating,
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
        methods: [self::METHOD_GET],
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
        methods: [self::METHOD_PUT],
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
            rating: $request->rating,
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
