<?php

declare(strict_types=1);

namespace App\Http\Controller\Api;

use App\Dto\CreateHentaiTag as DtoCreateHentaiTag;
use App\Exception\Dto\CreateTag\InvalidNameException;
use App\Exception\UseCase\CreateTag\TagNameAlreadyExistsException;
use App\Http\Factory\HentaiTagListResponseFactory;
use App\Http\Response\HentaiTagResponse;
use App\UseCase\CreateHentaiTag;
use App\UseCase\ListHentaiTags;
use Fig\Http\Message\RequestMethodInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
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
        name: 'app_api_list_tags',
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
        name: 'app_api_create_tag',
        methods: [RequestMethodInterface::METHOD_POST],
    )]
    public function create(#[MapRequestPayload(acceptFormat: 'json')] Request $request): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);
            $dtoCreateHentaiTag = new DtoCreateHentaiTag(name: $data['name']);
            $tag = $this->createHentaiTag->execute($dtoCreateHentaiTag);
            $response = new HentaiTagResponse($tag);

            return $this->jsonCreated($response);
        } catch (InvalidNameException $e) {
            return $this->jsonErrorBadRequest($e);
        } catch (TagNameAlreadyExistsException $e) {
            return $this->jsonErrorUnprocessableEntity($e);
        } catch (Throwable $e) {
            return $this->jsonErrorInternalServerError($e);
        }
    }
}
