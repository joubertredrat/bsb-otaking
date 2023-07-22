<?php

declare(strict_types=1);

namespace App\Http\Controller\Api;

use App\Dto\CreateTag as DtoCreateTag;
use App\Http\Factory\TagListResponseFactory;
use App\Http\Request\CreateTagRequest;
use App\Http\Response\TagResponse;
use App\UseCase\CreateTag;
use App\UseCase\ListTags;
use Fig\Http\Message\RequestMethodInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TagsController extends ApiController
{
    public function __construct(
        protected CreateTag $createTag,
        protected ListTags $listTags,
    ) {
    }

    #[Route(
        path: '/api/tags',
        name: 'app_api_tags_list',
        methods: [RequestMethodInterface::METHOD_GET],
    )]
    public function list(): JsonResponse
    {
        $tags = $this->listTags->execute();
        $response = TagListResponseFactory::createFromUsecase($tags);
        return $this->jsonOk($response);
    }

    #[Route(
        path: '/api/tags',
        name: 'app_api_tags_create',
        methods: [RequestMethodInterface::METHOD_POST],
    )]
    public function create(CreateTagRequest $request): JsonResponse
    {
        $dto = new DtoCreateTag(type: $request->type, name: $request->name);
        $tag = $this->createTag->execute($dto);
        $response = new TagResponse($tag);

        return $this->jsonCreated($response);
    }
}
