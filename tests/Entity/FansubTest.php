<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Fansub;
use PHPUnit\Framework\TestCase;

class FansubTest extends TestCase
{
    function testAttributes(): void
    {
        $nameExpected = 'Foo';
        $fansub = new Fansub();

        self::assertNull($fansub->getId());
        self::assertNull($fansub->getName());

        $fansub->setName($nameExpected);

        self::assertEquals($nameExpected, $fansub->getName());
    }
}
