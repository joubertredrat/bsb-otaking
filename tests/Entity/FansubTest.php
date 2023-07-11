<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Fansub;
use App\Entity\HentaiTitle;
use PHPUnit\Framework\TestCase;

class FansubTest extends TestCase
{
    function testAttributes(): void
    {
        $nameExpected = 'Foo';
        $fansub = new Fansub();

        self::assertNull($fansub->getId());
        self::assertNull($fansub->getName());
        self::assertCount(0, $fansub->getHentaiTitles());

        $fansub->setName($nameExpected);

        self::assertEquals($nameExpected, $fansub->getName());

        $hentaiTitleFoo = new HentaiTitle();
        $hentaiTitleFoo->setName('Foo');
        $hentaiTitleBar = new HentaiTitle();
        $hentaiTitleBar->setName('Foo');
        $fansub->addHentaiTitle($hentaiTitleFoo);
        self::assertCount(1, $fansub->getHentaiTitles());
        $fansub->addHentaiTitle($hentaiTitleFoo);
        self::assertCount(1, $fansub->getHentaiTitles());
        $fansub->addHentaiTitle($hentaiTitleBar);
        self::assertCount(2, $fansub->getHentaiTitles());
        $fansub->removeHentaiTitle($hentaiTitleFoo);
        self::assertCount(1, $fansub->getHentaiTitles());
        $fansub->removeHentaiTitle($hentaiTitleFoo);
        self::assertCount(1, $fansub->getHentaiTitles());
    }
}
