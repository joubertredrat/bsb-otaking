<?php

declare(strict_types=1);

namespace App\Tests\Http\Factory;

use App\Entity\Tag;
use App\Http\Factory\TagListResponseFactory;
use App\Http\Response\TagResponse;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class TagListResponseFactoryTest extends TestCase
{
    public function testCreateFromUsecase(): void
    {
        $tag = (new Tag())
            ->setType(Tag::TYPE_ALL)
            ->setName('foo')
            ->setCreatedAt(new DateTimeImmutable('2023-06-29 19:18:17'))
        ;
        $tagResponse = new TagResponse($tag);

        $arrayExpected = [
            'total' => 1,
            'data' => [$tagResponse],
        ];

        $response = TagListResponseFactory::createFromUsecase([$tag]);
        self::assertEquals($arrayExpected, $response->jsonSerialize());
    }
}
