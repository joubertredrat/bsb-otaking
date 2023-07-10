<?php

declare(strict_types=1);

namespace App\Tests\Http\Response;

use App\Entity\HentaiTag;
use App\Http\Response\HentaiTagResponse;
use App\Http\Response\ListResponse;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class ListResponseTest extends TestCase
{
    function testJsonSerialize(): void
    {
        $hentaiTag = new HentaiTag();
        $hentaiTag->setName('tag:foo');
        $hentaiTag->setCreatedAt(new DateTimeImmutable('2023-06-29 19:18:17'));
        $hentaiTagResponse = new HentaiTagResponse($hentaiTag);

        $arrayExpected = [
            'total' => 1,
            'data' => [$hentaiTagResponse],
        ];

        $response = new ListResponse();
        $response->add($hentaiTagResponse);

        self::assertEquals($arrayExpected, $response->jsonSerialize());
    }
}
