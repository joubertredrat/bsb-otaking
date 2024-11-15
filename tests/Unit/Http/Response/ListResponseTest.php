<?php

declare(strict_types=1);

namespace App\Tests\Unit\Http\Response;

use App\Entity\Tag;
use App\Http\Response\ListResponse;
use App\Http\Response\TagResponse;
use App\ValueObject\Total;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class ListResponseTest extends TestCase
{
    public function testJsonSerialize(): void
    {
        $tag = new Tag();
        $tag->setType(Tag::TYPE_ALL);
        $tag->setName('foo');
        $tag->setCreatedAt(new DateTimeImmutable('2023-06-29 19:18:17'));
        $tagResponse = new TagResponse($tag);
        $total = new Total(1);

        $arrayExpected = [
            'total' => $total->value,
            'data' => [$tagResponse],
        ];

        $response = new ListResponse($total);
        $response->add($tagResponse);

        self::assertEquals($arrayExpected, $response->jsonSerialize());
    }
}
