<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\HentaiTitle;
use App\Entity\Tag;
use App\Exception\Entity\Tag\InvalidNameException;
use App\Exception\Entity\Tag\InvalidTypeException;
use PHPUnit\Framework\TestCase;

class TagTest extends TestCase
{
    public function testAttributes(): void
    {
        $typeExpected = Tag::TYPE_ALL;
        $nameExpected = 'foo';
        $tag = new Tag();

        self::assertNull($tag->getId());
        self::assertNull($tag->getType());
        self::assertNull($tag->getName());
        self::assertEquals(':', $tag->getResourceName());
        self::assertCount(0, $tag->getHentaiTitles());

        $tag->setType($typeExpected);
        $tag->setName($nameExpected);

        self::assertEquals($typeExpected, $tag->getType());
        self::assertEquals($nameExpected, $tag->getName());
        self::assertEquals(sprintf('%s:%s', $typeExpected, $nameExpected), $tag->getResourceName());

        $hentaiTitleFoo = new HentaiTitle();
        $hentaiTitleFoo->setName('Foo');
        $hentaiTitleBar = new HentaiTitle();
        $hentaiTitleBar->setName('Bar');
        $tag->addHentaiTitle($hentaiTitleFoo);
        self::assertCount(1, $tag->getHentaiTitles());
        $tag->addHentaiTitle($hentaiTitleFoo);
        self::assertCount(1, $tag->getHentaiTitles());
        $tag->addHentaiTitle($hentaiTitleBar);
        self::assertCount(2, $tag->getHentaiTitles());
        $tag->removeHentaiTitle($hentaiTitleFoo);
        self::assertCount(1, $tag->getHentaiTitles());
        $tag->removeHentaiTitle($hentaiTitleFoo);
        self::assertCount(1, $tag->getHentaiTitles());
    }

    public function testAttributesWithInvalidType(): void
    {
        $this->expectException(InvalidTypeException::class);

        $tag = new Tag();
        $tag->setType('foo');
    }

    public function testAttributesWithInvalidName(): void
    {
        $this->expectException(InvalidNameException::class);

        $tag = new Tag();
        $tag->setName('FO0!');
    }
}
