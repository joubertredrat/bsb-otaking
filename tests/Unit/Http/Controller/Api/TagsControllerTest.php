<?php

declare(strict_types=1);

namespace App\Tests\Unit\Http\Controller\Api;

use App\Dto\CreateTag as DtoCreateTag;
use App\Entity\Tag;
use App\Http\Controller\Api\TagsController;
use App\Http\Request\CreateTagRequest;
use App\Tests\Helper;
use App\Tests\Unit\Http\Controller\ControllerTestCase;
use App\UseCase\CreateTag;
use App\UseCase\ListTags;
use App\ValueObject\PaginatedItems;
use App\ValueObject\Total;
use Mockery;

class TagsControllerTest extends ControllerTestCase
{
    public function testList(): void
    {
        $container = $this->getContainerMock();

        $createTag = Mockery::mock(CreateTag::class);
        $tagFoo = (new Tag())
            ->setType(Tag::TYPE_ALL)
            ->setName('foo')
            ->setCreatedAtNow()
        ;
        $tagBar = (new Tag())
            ->setType(Tag::TYPE_ALL)
            ->setName('bar')
            ->setCreatedAtNow()
        ;
        $listTags = Mockery::mock(ListTags::class);
        $listTags
            ->shouldReceive('execute')
            ->andReturn(new PaginatedItems([$tagFoo, $tagBar], new Total(2)))
        ;

        /** @var CreateTag $createTag */
        /** @var ListTags $listTags */
        $controller = new TagsController(
            createTag: $createTag,
            listTags: $listTags,
        );
        $controller->setContainer($container);

        $request = Helper::getRequestMock(queryData: ['page' => 1, 'itemsPerPage' => 10]);

        $response = $controller->list($request);
        self::assertEqualStatusOk($response->getStatusCode());
    }

    public function testTypes(): void
    {
        $container = $this->getContainerMock();
        $createTag = Mockery::mock(CreateTag::class);
        $listTags = Mockery::mock(ListTags::class);

        /** @var CreateTag $createTag */
        /** @var ListTags $listTags */
        $controller = new TagsController(
            createTag: $createTag,
            listTags: $listTags,
        );
        $controller->setContainer($container);

        $response = $controller->types();
        self::assertEqualStatusOk($response->getStatusCode());
    }

    public function testCreate(): void
    {
        $container = $this->getContainerMock();

        $tagFoo = (new Tag())
            ->setType(Tag::TYPE_ALL)
            ->setName('foo')
            ->setCreatedAtNow()
        ;
        $createTag = Mockery::mock(CreateTag::class);
        $createTag
            ->shouldReceive('execute')
            ->with(Mockery::on(function ($argument) {
                return $argument instanceof DtoCreateTag;
            }))
            ->andReturn($tagFoo)
        ;
        $listTags = Mockery::mock(ListTags::class);

        /** @var CreateTag $createTag */
        /** @var ListTags $listTags */
        $controller = new TagsController(
            createTag: $createTag,
            listTags: $listTags,
        );
        $controller->setContainer($container);

        $validator = Helper::getValidationMock();
        $request = Helper::getRequestMock(bodyData: ['type' => 'all', 'name' => 'foo']);
        $requestStack = Helper::getRequestStackMock($request);
        $createTagRequest = new CreateTagRequest(
            validator: $validator,
            requestStack: $requestStack,
            convertCase: false,
        );

        $response = $controller->create($createTagRequest);
        self::assertEqualStatusCreated($response->getStatusCode());
    }
}
