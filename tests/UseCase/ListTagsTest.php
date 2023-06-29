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
        $tagBarFoo = new Tag();
        $tagBarFoo->setName('bar:foo');
        $tagFooBar = new Tag();
        $tagFooBar->setName('foo:bar');

        $tagsExpected = [$tagBarFoo, $tagFooBar];

        $tagRepository = Mockery::mock(TagRepositoryInterface::class);
        $tagRepository
            ->shouldReceive('list')
            ->andReturn($tagsExpected)
        ;

        $listTags = new ListTags($tagRepository);
        $tagsGot = $listTags->execute();

        self::assertEquals($tagsExpected, $tagsGot);
    }
}
