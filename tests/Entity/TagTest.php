<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Tag;
use App\Entity\Title;
use PHPUnit\Framework\TestCase;

class TagTest extends TestCase
{
    function testAttributes(): void
    {
        $nameExpected = 'tag:foo';
        $tag = new Tag();

        self::assertNull($tag->getId());
        self::assertNull($tag->getName());
        self::assertCount(0, $tag->getTitle());

        $tag->setName($nameExpected);

        self::assertEquals($nameExpected, $tag->getName());

        $titleFoo = new Title();
        $titleFoo->setName('Foo');
        $titleBar = new Title();
        $titleBar->setName('Bar');
        $tag->addTitle($titleFoo);
        self::assertCount(1, $tag->getTitle());
        $tag->addTitle($titleFoo);
        self::assertCount(1, $tag->getTitle());
        $tag->addTitle($titleBar);
        self::assertCount(2, $tag->getTitle());
        $tag->removeTitle($titleFoo);
        self::assertCount(1, $tag->getTitle());
        $tag->removeTitle($titleFoo);
        self::assertCount(1, $tag->getTitle());
    }
}
