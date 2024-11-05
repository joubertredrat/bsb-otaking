<?php

declare(strict_types=1);

namespace App\Tests\Unit\Http\Factory;

use App\Entity\Fansub;
use App\Http\Factory\FansubListResponseFactory;
use App\Http\Response\FansubResponse;
use App\ValueObject\PaginatedItems;
use App\ValueObject\Total;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class FansubListResponseFactoryTest extends TestCase
{
    public function testCreateFromUsecase(): void
    {
        $fansub = new Fansub();
        $fansub->setName('Fansub Foo');
        $fansub->setCreatedAt(new DateTimeImmutable('2023-06-29 19:18:17'));
        $totalExpected = new Total(1);

        $arrayExpected = [
            'total' => $totalExpected->value,
            'data' => [new FansubResponse($fansub)],
        ];
        $paginatedItems = new PaginatedItems([$fansub], $totalExpected);

        $response = FansubListResponseFactory::createFromUsecase($paginatedItems);
        self::assertEquals($arrayExpected, $response->jsonSerialize());
    }
}
