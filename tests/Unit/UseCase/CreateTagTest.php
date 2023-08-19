<?php

declare(strict_types=1);

namespace App\Tests\Unit\UseCase;

use App\Dto\CreateTag as DtoCreateTag;
use App\Entity\Tag;
use App\Exception\UseCase\CreateTag\TagAlreadyExistsException;
use App\Repository\TagRepositoryInterface;
use App\UseCase\CreateTag;
use Mockery;
use PHPUnit\Framework\TestCase;

class CreateTagTest extends TestCase
{
    public function testCreateTagWithSuccess(): void
    {
        $dtoCreateTag = new DtoCreateTag(type: Tag::TYPE_ALL, name: 'bar');

        $tagRepository = Mockery::mock(TagRepositoryInterface::class);
        $tagRepository
            ->shouldReceive('getByTypeName')
            ->withArgs([Tag::TYPE_ALL, 'bar'])
            ->andReturn(null)
        ;
        $tagRepository
            ->shouldReceive('save')
            ->once()
        ;

        $usecase = new CreateTag($tagRepository);
        $tagGot = $usecase->execute($dtoCreateTag);

        self::assertEquals($dtoCreateTag->type, $tagGot->getType());
        self::assertEquals($dtoCreateTag->name, $tagGot->getName());
    }

    public function testCreateTagWithNameAlreadyExists(): void
    {
        $this->expectException(TagAlreadyExistsException::class);

        $dtoCreateTag = new DtoCreateTag(type: Tag::TYPE_ALL, name: 'bar');
        $tagFound = new Tag();
        $tagFound->setType(Tag::TYPE_ALL);
        $tagFound->setName('bar');

        $tagRepository = Mockery::mock(TagRepositoryInterface::class);
        $tagRepository
            ->shouldReceive('getByTypeName')
            ->withArgs(['all', 'bar'])
            ->andReturn($tagFound)
        ;

        $usecase = new CreateTag($tagRepository);
        $usecase->execute($dtoCreateTag);
    }
}
