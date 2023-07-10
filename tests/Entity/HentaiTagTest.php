<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\HentaiTag;
use App\Entity\HentaiTitle;
use PHPUnit\Framework\TestCase;

class HentaiTagTest extends TestCase
{
    function testAttributes(): void
    {
        $nameExpected = 'tag:foo';
        $hentaiTag = new HentaiTag();

        self::assertNull($hentaiTag->getId());
        self::assertNull($hentaiTag->getName());
        self::assertCount(0, $hentaiTag->getTitle());

        $hentaiTag->setName($nameExpected);

        self::assertEquals($nameExpected, $hentaiTag->getName());

        $hentaiTitleFoo = new HentaiTitle();
        $hentaiTitleFoo->setName('Foo');
        $hentaiTitleBar = new HentaiTitle();
        $hentaiTitleBar->setName('Bar');
        $hentaiTag->addTitle($hentaiTitleFoo);
        self::assertCount(1, $hentaiTag->getTitle());
        $hentaiTag->addTitle($hentaiTitleFoo);
        self::assertCount(1, $hentaiTag->getTitle());
        $hentaiTag->addTitle($hentaiTitleBar);
        self::assertCount(2, $hentaiTag->getTitle());
        $hentaiTag->removeTitle($hentaiTitleFoo);
        self::assertCount(1, $hentaiTag->getTitle());
        $hentaiTag->removeTitle($hentaiTitleFoo);
        self::assertCount(1, $hentaiTag->getTitle());
    }
}
