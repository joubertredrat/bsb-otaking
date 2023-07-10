<?php

declare(strict_types=1);

namespace App\Tests\Http\Response;

use App\Entity\HentaiTag;
use App\Http\Response\HentaiTagResponse;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class HentaiTagResponseTest extends TestCase
{
    function testJsonSerialize(): void
    {
        $arrayExpected = [
            'id' => null,
            'name' => 'tag:foo',
            'createdAt' => '2023-06-29 19:18:17',
            'updatedAt' => null,
        ];

        $hentaiTag = new HentaiTag();
        $hentaiTag->setName('tag:foo');
        $hentaiTag->setCreatedAt(new DateTimeImmutable('2023-06-29 19:18:17'));
        $response = new HentaiTagResponse($hentaiTag);

        self::assertEquals($arrayExpected, $response->jsonSerialize());
    }
}
