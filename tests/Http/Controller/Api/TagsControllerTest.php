<?php

declare(strict_types=1);

namespace App\Tests\Http\Controller\Api;

use App\Dto\CreateTag as DtoCreateTag;
use App\Entity\Tag;
use App\Http\Controller\Api\TagsController;
use App\Http\Request\CreateTagRequest;
use App\Tests\Helper;
use App\Tests\Http\Controller\ControllerTestCase;
use App\UseCase\CreateTag;
use App\UseCase\ListTags;
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
            ->andReturn([$tagFoo, $tagBar])
        ;

        $controller = new TagsController(
            createTag: $createTag,
            listTags: $listTags,
        );
        $controller->setContainer($container);

        $response = $controller->list();
        self::assertEqualStatusOk($response->getStatusCode());
    }

    public function testTypes(): void
    {
        $container = $this->getContainerMock();
        $createTag = Mockery::mock(CreateTag::class);
        $listTags = Mockery::mock(ListTags::class);

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

        $controller = new TagsController(
            createTag: $createTag,
            listTags: $listTags,
        );
        $controller->setContainer($container);

        $validator = Helper::getValidationMock();
        $request = Helper::getRequestMock(['type' => 'all', 'name' => 'foo']);
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
