<?php

declare(strict_types=1);

namespace App\Tests\Response;

use App\Entity\Tag;
use App\Response\TagResponse;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class TagResponseTest extends TestCase
{
    function testJsonSerialize(): void
    {
        $arrayExpected = [
            'id' => null,
            'name' => 'tag:foo',
            'created_at' => '2023-06-29 19:18:17',
            'updated_at' => null,
        ];

        $tag = new Tag();
        $tag->setName('tag:foo');
        $tag->setCreatedAt(new DateTimeImmutable('2023-06-29 19:18:17'));
        $response = new TagResponse($tag);

        self::assertEquals($arrayExpected, $response->jsonSerialize());
    }
}
