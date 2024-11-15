<?php

declare(strict_types=1);

namespace App\Tests\Unit\Http\Factory;

use App\Entity\HentaiTitle;
use App\Http\Factory\HentaiTitleListResponseFactory;
use App\Http\Response\HentaiTitleResponse;
use App\ValueObject\PaginatedItems;
use App\ValueObject\Total;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class HentaiTitleListResponseFactoryTest extends TestCase
{
    public function testCreateFromUsecase(): void
    {
        $hentaiTitle = new HentaiTitle();
        $hentaiTitle->setName('Foo');
        $hentaiTitle->setCreatedAt(new DateTimeImmutable('2023-06-29 19:18:17'));
        $totalExpected = new Total(1);

        $arrayExpected = [
            'total' => $totalExpected->value,
            'data' => [new HentaiTitleResponse($hentaiTitle)],
        ];
        $paginatedItems = new PaginatedItems([$hentaiTitle], $totalExpected);

        $response = HentaiTitleListResponseFactory::createFromUsecase($paginatedItems);
        self::assertEquals($arrayExpected, $response->jsonSerialize());
    }
}
