<?php

declare(strict_types=1);

namespace App\Tests\Unit\Http\Response;

use App\Entity\Tag;
use App\Http\Response\TagResponse;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class TagResponseTest extends TestCase
{
    public function testJsonSerialize(): void
    {
        $arrayExpected = [
            'id' => null,
            'type' => Tag::TYPE_ALL,
            'name' => 'foo',
            'resourceName' => sprintf('%s:foo', Tag::TYPE_ALL),
            'createdAt' => '2023-06-29 19:18:17',
            'updatedAt' => null,
        ];

        $tag = new Tag();
        $tag->setType(Tag::TYPE_ALL);
        $tag->setName('foo');
        $tag->setCreatedAt(new DateTimeImmutable('2023-06-29 19:18:17'));
        $response = new TagResponse($tag);

        self::assertEquals($arrayExpected, $response->jsonSerialize());
    }
}
