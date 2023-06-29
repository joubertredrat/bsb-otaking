<?php

declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\Tag;
use App\Factory\TagListResponseFactory;
use App\Response\TagResponse;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class TagListResponseFactoryTest extends TestCase
{
    function testCreateFromUsecase(): void
    {
        $tag = new Tag();
        $tag->setName('tag:foo');
        $tag->setCreatedAt(new DateTimeImmutable('2023-06-29 19:18:17'));
        $tagResponse = new TagResponse($tag);

        $arrayExpected = [
            'total' => 1,
            'data' => [$tagResponse],
        ];

        $response = TagListResponseFactory::createFromUsecase([$tag]);
        self::assertEquals($arrayExpected, $response->jsonSerialize());
    }
}
