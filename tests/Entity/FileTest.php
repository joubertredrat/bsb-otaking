<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\File;
use App\Entity\Title;
use PHPUnit\Framework\TestCase;

class FileTest extends TestCase
{
    function testAttributes(): void
    {
        $nameExpected = 'episode_01.mkv';
        $titleExpected = new Title();
        $titleExpected->setName('Foo');

        $file = new File();

        self::assertNull($file->getId());
        self::assertNull($file->getName());
        self::assertNull($file->getTitle());

        $file->setName($nameExpected);
        $file->setTitle($titleExpected);

        self::assertEquals($nameExpected, $file->getName());
        self::assertEquals($titleExpected, $file->getTitle());
    }
}
