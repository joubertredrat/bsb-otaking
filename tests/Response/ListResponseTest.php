<?php

declare(strict_types=1);

namespace App\Tests\Response;

use App\Entity\Tag;
use App\Response\ListResponse;
use App\Response\TagResponse;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class ListResponseTest extends TestCase
{
    function testJsonSerialize(): void
    {
        $tag = new Tag();
        $tag->setName('tag:foo');
        $tag->setCreatedAt(new DateTimeImmutable('2023-06-29 19:18:17'));
        $tagResponse = new TagResponse($tag);

        $arrayExpected = [
            'total' => 1,
            'data' => [$tagResponse],
        ];

        $response = new ListResponse();
        $response->add($tagResponse);

        self::assertEquals($arrayExpected, $response->jsonSerialize());
    }
}
