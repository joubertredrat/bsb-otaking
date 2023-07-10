<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Dto\CreateTag as DtoCreateTag;
use App\Exception\Dto\CreateTag\InvalidNameException;
use App\Exception\UseCase\CreateTag\TagNameAlreadyExistsException;
use App\Factory\TagListResponseFactory;
use App\Response\TagResponse;
use App\UseCase\CreateTag;
use App\UseCase\ListTags;
use Fig\Http\Message\RequestMethodInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class TagsController extends ApiController
{
    public function __construct(
        protected CreateTag $createTag,
        protected ListTags $listTags,
    ) {
    }

    #[Route('/api/tags', name: 'app_api_list_tags', methods: [RequestMethodInterface::METHOD_GET])]
    public function list(): JsonResponse
    {
        try {
            $tags = $this->listTags->execute();
            $response = TagListResponseFactory::createFromUsecase($tags);
            return $this->jsonOk($response);
        } catch (Throwable $e) {
            return $this->jsonErrorInternalServerError($e);
        }
    }

    #[Route('/api/tags', name: 'app_api_create_tag', methods: [RequestMethodInterface::METHOD_POST])]
    public function create(#[MapRequestPayload(acceptFormat: 'json')] Request $request): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);
            $dtoCreateTag = new DtoCreateTag(name: $data['name']);
            $tag = $this->createTag->execute($dtoCreateTag);
            $response = new TagResponse($tag);

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
