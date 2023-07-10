<?php

declare(strict_types=1);

namespace App\Http\Controller\Api;

use App\Dto\CreateHentaiTag as DtoCreateHentaiTag;
use App\Exception\Dto\CreateHentaiTag\InvalidNameException;
use App\Exception\UseCase\CreateHentaiTag\HentaiTagNameAlreadyExistsException;
use App\Http\Factory\HentaiTagListResponseFactory;
use App\Http\Request\CreateHentaiTagRequest;
use App\Http\Response\HentaiTagResponse;
use App\UseCase\CreateHentaiTag;
use App\UseCase\ListHentaiTags;
use Fig\Http\Message\RequestMethodInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class HentaiTagsController extends ApiController
{
    public function __construct(
        protected CreateHentaiTag $createHentaiTag,
        protected ListHentaiTags $listHentaiTags,
    ) {
    }

    #[Route(
        path: '/api/hentai/tags',
        name: 'app_api_hentai_tags_list',
        methods: [RequestMethodInterface::METHOD_GET],
    )]
    public function list(): JsonResponse
    {
        try {
            $tags = $this->listHentaiTags->execute();
            $response = HentaiTagListResponseFactory::createFromUsecase($tags);
            return $this->jsonOk($response);
        } catch (Throwable $e) {
            return $this->jsonErrorInternalServerError($e);
        }
    }

    #[Route(
        path: '/api/hentai/tags',
        name: 'app_api_hentai_tags_create',
        methods: [RequestMethodInterface::METHOD_POST],
    )]
    public function create(CreateHentaiTagRequest $request): JsonResponse
    {
        try {
            $dto = new DtoCreateHentaiTag(name: $request->name);
            $tag = $this->createHentaiTag->execute($dto);
            $response = new HentaiTagResponse($tag);

            return $this->jsonCreated($response);
        } catch (InvalidNameException $e) {
            return $this->jsonErrorBadRequest($e);
        } catch (HentaiTagNameAlreadyExistsException $e) {
            return $this->jsonErrorUnprocessableEntity($e);
        } catch (Throwable $e) {
            return $this->jsonErrorInternalServerError($e);
        }
    }
}
