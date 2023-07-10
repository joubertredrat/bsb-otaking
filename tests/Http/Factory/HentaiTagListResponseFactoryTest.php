<?php

declare(strict_types=1);

namespace App\Tests\Http\Factory;

use App\Entity\HentaiTag;
use App\Http\Factory\HentaiTagListResponseFactory;
use App\Http\Response\HentaiTagResponse;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class HentaiTagListResponseFactoryTest extends TestCase
{
    function testCreateFromUsecase(): void
    {
        $hentaiTag = new HentaiTag();
        $hentaiTag->setName('tag:foo');
        $hentaiTag->setCreatedAt(new DateTimeImmutable('2023-06-29 19:18:17'));
        $hentaiTagResponse = new HentaiTagResponse($hentaiTag);

        $arrayExpected = [
            'total' => 1,
            'data' => [$hentaiTagResponse],
        ];

        $response = HentaiTagListResponseFactory::createFromUsecase([$hentaiTag]);
        self::assertEquals($arrayExpected, $response->jsonSerialize());
    }
}
