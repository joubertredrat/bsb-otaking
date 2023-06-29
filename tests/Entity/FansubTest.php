<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Fansub;
use App\Entity\Title;
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

        $titleFoo = new Title();
        $titleFoo->setName('Foo');
        $titleBar = new Title();
        $titleBar->setName('Bar');
        $fansub->addTitle($titleFoo);
        self::assertCount(1, $fansub->getTitles());
        $fansub->addTitle($titleFoo);
        self::assertCount(1, $fansub->getTitles());
        $fansub->addTitle($titleBar);
        self::assertCount(2, $fansub->getTitles());
        $fansub->removeTitle($titleFoo);
        self::assertCount(1, $fansub->getTitles());
        $fansub->removeTitle($titleFoo);
        self::assertCount(1, $fansub->getTitles());
    }
}
