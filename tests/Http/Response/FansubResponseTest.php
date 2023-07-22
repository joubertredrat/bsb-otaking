<?php

declare(strict_types=1);

namespace App\Tests\Http\Response;

use App\Entity\Fansub;
use App\Http\Response\FansubResponse;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class FansubResponseTest extends TestCase
{
    public function testJsonSerialize(): void
    {
        $arrayExpected = [
            'id' => null,
            'name' => 'Fansub Foo',
            'createdAt' => '2023-06-29 19:18:17',
            'updatedAt' => null,
        ];

        $fansub = new Fansub();
        $fansub->setName('Fansub Foo');
        $fansub->setCreatedAt(new DateTimeImmutable('2023-06-29 19:18:17'));
        $response = new FansubResponse($fansub);

        self::assertEquals($arrayExpected, $response->jsonSerialize());
    }
}
