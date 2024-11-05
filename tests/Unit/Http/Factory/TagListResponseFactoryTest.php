<?php

declare(strict_types=1);

namespace App\Tests\Unit\Http\Factory;

use App\Entity\Tag;
use App\Http\Factory\TagListResponseFactory;
use App\Http\Response\TagResponse;
use App\ValueObject\PaginatedItems;
use App\ValueObject\Total;
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
        $totalExpected = new Total(1);

        $arrayExpected = [
            'total' => $totalExpected->value,
            'data' => [new TagResponse($tag)],
        ];
        $paginatedItems = new PaginatedItems([$tag], $totalExpected);

        $response = TagListResponseFactory::createFromUsecase($paginatedItems);
        self::assertEquals($arrayExpected, $response->jsonSerialize());
    }
}
