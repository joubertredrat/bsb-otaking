<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\HentaiFile;
use App\Entity\HentaiTitle;
use PHPUnit\Framework\TestCase;

class HentaiFileTest extends TestCase
{
    public function testAttributes(): void
    {
        $nameExpected = 'episode_01.mkv';
        $hentaiTitleExpected = new HentaiTitle();
        $hentaiTitleExpected->setName('Foo');

        $hentaiFile = new HentaiFile();

        self::assertNull($hentaiFile->getId());
        self::assertNull($hentaiFile->getName());
        self::assertNull($hentaiFile->getTitle());

        $hentaiFile->setName($nameExpected);
        $hentaiFile->setTitle($hentaiTitleExpected);

        self::assertEquals($nameExpected, $hentaiFile->getName());
        self::assertEquals($hentaiTitleExpected, $hentaiFile->getTitle());
    }
}
