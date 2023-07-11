<?php

declare(strict_types=1);

namespace App\Tests\Http\Factory;

use App\Entity\HentaiTitle;
use App\Http\Factory\HentaiTitleListResponseFactory;
use App\Http\Response\HentaiTitleResponse;
use PHPUnit\Framework\TestCase;

class HentaiTitleListResponseFactoryTest extends TestCase
{
    function testCreateFromUsecase(): void
    {
        $hentaiTitle = new HentaiTitle();
        $hentaiTitle->setName('Foo');
        $hentaiTitleResponse = new HentaiTitleResponse($hentaiTitle);

        $arrayExpected = [
            'total' => 1,
            'data' => [$hentaiTitleResponse],
        ];

        $response = HentaiTitleListResponseFactory::createFromUsecase([$hentaiTitle]);
        self::assertEquals($arrayExpected, $response->jsonSerialize());
    }
}
