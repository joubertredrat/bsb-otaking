<?php

declare(strict_types=1);

namespace App\Tests\Unit\UseCase;

use App\Dto\ListTags as DtoListTags;
use App\Dto\Pagination;
use App\Entity\Tag;
use App\Repository\TagRepositoryInterface;
use App\UseCase\ListTags;
use Mockery;
use PHPUnit\Framework\TestCase;

class ListTagsTest extends TestCase
{
    public function testListTagsWithSuccess(): void
    {
        $dtoListTags = new DtoListTags(new Pagination(1, 10), '');

        $tagFoo = new Tag();
        $tagFoo->setType(Tag::TYPE_ALL);
        $tagFoo->setName('foo');
        $tagBar = new Tag();
        $tagBar->setType(Tag::TYPE_ALL);
        $tagBar->setName('bar');

        $tagsExpected = [$tagFoo, $tagBar];
        $totalExpected = 2;

        $tagRepository = Mockery::mock(TagRepositoryInterface::class);
        $tagRepository
            ->shouldReceive('list')
            ->andReturn($tagsExpected)
        ;
        $tagRepository
            ->shouldReceive('countAll')
            ->andReturn($totalExpected)
        ;

        /** @var TagRepositoryInterface $tagRepository */
        $usecase = new ListTags($tagRepository);
        $tagsGot = $usecase->execute($dtoListTags);

        self::assertEquals($tagsExpected, $tagsGot->items);
        self::assertEquals($totalExpected, $tagsGot->total->value);
    }
}
