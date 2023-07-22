<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Dto\CreateHentaiTitle as DtoCreateHentaiTitle;
use App\Entity\Fansub;
use App\Entity\HentaiFile;
use App\Entity\HentaiTitle;
use App\Entity\Tag;
use PHPUnit\Framework\TestCase;

class HentaiTitleTest extends TestCase
{
    public function testAttributes(): void
    {
        $nameExpected = 'Foo';
        $alternativeNamesExpected = [];
        $typeExpected = DtoCreateHentaiTitle::TYPE_2D;
        $languageExpected = DtoCreateHentaiTitle::LANGUAGE_PT_BR;
        $episodesExpected = 2;
        $statusDownloadExpected = DtoCreateHentaiTitle::STATUS_DOWNLOAD_COMPLETE;
        $statusViewExpected = DtoCreateHentaiTitle::STATUS_VIEW_DONE;

        $hentaiTitle = new HentaiTitle();

        self::assertNull($hentaiTitle->getId());
        self::assertNull($hentaiTitle->getName());
        self::assertCount(0, $hentaiTitle->getAlternativeNames());
        self::assertNull($hentaiTitle->getType());
        self::assertNull($hentaiTitle->getLanguage());
        self::assertNull($hentaiTitle->getEpisodes());
        self::assertNull($hentaiTitle->getStatusDownload());
        self::assertNull($hentaiTitle->getStatusView());
        self::assertCount(0, $hentaiTitle->getFansubs());
        self::assertCount(0, $hentaiTitle->getFiles());
        self::assertCount(0, $hentaiTitle->getTags());

        $hentaiTitle->setName($nameExpected);
        $hentaiTitle->setAlternativeNames($alternativeNamesExpected);
        $hentaiTitle->setType($typeExpected);
        $hentaiTitle->setLanguage($languageExpected);
        $hentaiTitle->setEpisodes($episodesExpected);
        $hentaiTitle->setStatusDownload($statusDownloadExpected);
        $hentaiTitle->setStatusView($statusViewExpected);

        $fansubFoo = new Fansub();
        $fansubFoo->setName('Foo');
        $fansubBar = new Fansub();
        $fansubBar->setName('Bar');
        $hentaiTitle->addFansub($fansubFoo);
        self::assertCount(1, $hentaiTitle->getFansubs());
        $hentaiTitle->addFansub($fansubFoo);
        self::assertCount(1, $hentaiTitle->getFansubs());
        $hentaiTitle->addFansub($fansubBar);
        self::assertCount(2, $hentaiTitle->getFansubs());
        $hentaiTitle->removeFansub($fansubFoo);
        self::assertCount(1, $hentaiTitle->getFansubs());
        $hentaiTitle->removeFansub($fansubFoo);
        self::assertCount(1, $hentaiTitle->getFansubs());

        $hentaiFileOne = new HentaiFile();
        $hentaiFileOne->setName('episode_01.mkv');
        $hentaiFileTwo = new HentaiFile();
        $hentaiFileTwo->setName('episode_02.mkv');
        $hentaiTitle->addFile($hentaiFileOne);
        self::assertCount(1, $hentaiTitle->getFiles());
        $hentaiTitle->addFile($hentaiFileOne);
        self::assertCount(1, $hentaiTitle->getFiles());
        $hentaiTitle->addFile($hentaiFileTwo);
        self::assertCount(2, $hentaiTitle->getFiles());
        $hentaiTitle->removeFile($hentaiFileOne);
        self::assertCount(1, $hentaiTitle->getFiles());
        $hentaiTitle->removeFile($hentaiFileOne);
        self::assertCount(1, $hentaiTitle->getFiles());

        $tagFoo = (new Tag())
            ->setType(Tag::TYPE_ALL)
            ->setName('foo')
        ;
        $tagBar = (new Tag())
            ->setType(Tag::TYPE_ALL)
            ->setName('bar')
        ;
        $hentaiTitle->addTag($tagFoo);
        self::assertCount(1, $hentaiTitle->getTags());
        $hentaiTitle->addTag($tagFoo);
        self::assertCount(1, $hentaiTitle->getTags());
        $hentaiTitle->addTag($tagBar);
        self::assertCount(2, $hentaiTitle->getTags());
        $hentaiTitle->removeTag($tagFoo);
        self::assertCount(1, $hentaiTitle->getTags());
        $hentaiTitle->removeTag($tagFoo);
        self::assertCount(1, $hentaiTitle->getTags());
    }
}
