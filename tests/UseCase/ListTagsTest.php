<?php

declare(strict_types=1);

namespace App\Tests\UseCase;

use App\Entity\Tag;
use App\Repository\TagRepositoryInterface;
use App\UseCase\ListTags;
use Mockery;
use PHPUnit\Framework\TestCase;

class ListTagsTest extends TestCase
{
    public function testListTagsWithSuccess(): void
    {
        $tagFoo = new Tag();
        $tagFoo->setType(Tag::TYPE_ALL);
        $tagFoo->setName('foo');
        $tagBar = new Tag();
        $tagBar->setType(Tag::TYPE_ALL);
        $tagBar->setName('bar');

        $tagsExpected = [$tagFoo, $tagBar];

        $tagRepository = Mockery::mock(TagRepositoryInterface::class);
        $tagRepository
            ->shouldReceive('list')
            ->andReturn($tagsExpected)
        ;

        $usecase = new ListTags($tagRepository);
        $tagsGot = $usecase->execute();

        self::assertEquals($tagsExpected, $tagsGot);
    }
}
