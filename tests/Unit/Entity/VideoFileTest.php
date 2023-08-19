<?php

declare(strict_types=1);

namespace App\Tests\Unit\Entity;

use App\Entity\HentaiTitle;
use App\Entity\VideoFile;
use App\Exception\Entity\VideoFile\InvalidNameException;
use App\Tests\Helper;
use PHPUnit\Framework\TestCase;

class VideoFileTest extends TestCase
{
    public function testAttributes(): void
    {
        $nameExpected = Helper::VIDEOFILE_01;
        $videoFile = new VideoFile();

        self::assertNull($videoFile->getId());
        self::assertNull($videoFile->getName());
        self::assertCount(0, $videoFile->getHentaiTitles());

        $videoFile->setName($nameExpected);
        self::assertEquals($nameExpected, $videoFile->getName());

        $hentaiTitleFoo = (new HentaiTitle())->setName('Foo');
        $hentaiTitleBar = (new HentaiTitle())->setName('Bar');
        $videoFile->addHentaiTitle($hentaiTitleFoo);
        self::assertCount(1, $videoFile->getHentaiTitles());
        $videoFile->addHentaiTitle($hentaiTitleFoo);
        self::assertCount(1, $videoFile->getHentaiTitles());
        $videoFile->addHentaiTitle($hentaiTitleBar);
        self::assertCount(2, $videoFile->getHentaiTitles());
        $videoFile->removeHentaiTitle($hentaiTitleFoo);
        self::assertCount(1, $videoFile->getHentaiTitles());
        $videoFile->removeHentaiTitle($hentaiTitleFoo);
        self::assertCount(1, $videoFile->getHentaiTitles());
    }

    public function testAttributesWithInvalidName(): void
    {
        $this->expectException(InvalidNameException::class);

        (new VideoFile())->setName('foo');
    }
}
