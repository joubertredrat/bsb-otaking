<?php

declare(strict_types=1);

namespace App\Tests\UseCase;

use App\Dto\CreateTag as DtoCreateTag;
use App\Entity\Tag;
use App\Exception\UseCase\CreateTag\TagNameAlreadyExistsException;
use App\Repository\TagRepositoryInterface;
use App\UseCase\CreateTag;
use Mockery;
use PHPUnit\Framework\TestCase;

class CreateTagTest extends TestCase
{
    public function testCreateTagWithSuccess(): void
    {
        $dtoCreateTag = new DtoCreateTag(name: 'foo:bar');

        $tagRepository = Mockery::mock(TagRepositoryInterface::class);
        $tagRepository
            ->shouldReceive('getByName')
            ->withArgs(['foo:bar'])
            ->andReturn(null)
        ;
        $tagRepository
            ->shouldReceive('save')
            ->once()
        ;

        $createTag = new CreateTag($tagRepository);
        $tagGot = $createTag->execute($dtoCreateTag);

        self::assertEquals($dtoCreateTag->name, $tagGot->getName());
    }

    public function testCreateTagWithNameAlreadyExists(): void
    {
        $this->expectException(TagNameAlreadyExistsException::class);

        $dtoCreateTag = new DtoCreateTag(name: 'foo:bar');
        $tagFound = new Tag();
        $tagFound->setName('foo:bar');

        $tagRepository = Mockery::mock(TagRepositoryInterface::class);
        $tagRepository
            ->shouldReceive('getByName')
            ->withArgs(['foo:bar'])
            ->andReturn($tagFound)
        ;

        $createTag = new CreateTag($tagRepository);
        $createTag->execute($dtoCreateTag);
    }
}
