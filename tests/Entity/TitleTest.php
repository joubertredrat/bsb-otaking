<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Dto\CreateTitle as DtoCreateTitle;
use App\Entity\Fansub;
use App\Entity\File;
use App\Entity\Tag;
use App\Entity\Title;
use PHPUnit\Framework\TestCase;

class TitleTest extends TestCase
{
    function testAttributes(): void
    {
        $nameExpected = 'Foo';
        $alternativeNamesExpected = [];
        $typeExpected = DtoCreateTitle::TYPE_2D;
        $languageExpected = DtoCreateTitle::LANGUAGE_PT_BR;
        $episodesExpected = 2;
        $statusDownloadExpected = DtoCreateTitle::STATUS_DOWNLOAD_COMPLETE;
        $statusViewExpected = DtoCreateTitle::STATUS_VIEW_DONE;

        $title = new Title();

        self::assertNull($title->getId());
        self::assertNull($title->getName());
        self::assertCount(0, $title->getAlternativeNames());
        self::assertNull($title->getType());
        self::assertNull($title->getLanguage());
        self::assertNull($title->getEpisodes());
        self::assertNull($title->getStatusDownload());
        self::assertNull($title->getStatusView());
        self::assertCount(0, $title->getFansubs());
        self::assertCount(0, $title->getFiles());
        self::assertCount(0, $title->getTags());

        $title->setName($nameExpected);
        $title->setAlternativeNames($alternativeNamesExpected);
        $title->setType($typeExpected);
        $title->setLanguage($languageExpected);
        $title->setEpisodes($episodesExpected);
        $title->setStatusDownload($statusDownloadExpected);
        $title->setStatusView($statusViewExpected);

        $fansubFoo = new Fansub();
        $fansubFoo->setName('Foo');
        $fansubBar = new Fansub();
        $fansubBar->setName('Bar');
        $title->addFansub($fansubFoo);
        self::assertCount(1, $title->getFansubs());
        $title->addFansub($fansubFoo);
        self::assertCount(1, $title->getFansubs());
        $title->addFansub($fansubBar);
        self::assertCount(2, $title->getFansubs());
        $title->removeFansub($fansubFoo);
        self::assertCount(1, $title->getFansubs());
        $title->removeFansub($fansubFoo);
        self::assertCount(1, $title->getFansubs());

        $fileOne = new File();
        $fileOne->setName('episode_01.mkv');
        $fileTwo = new File();
        $fileTwo->setName('episode_02.mkv');
        $title->addFile($fileOne);
        self::assertCount(1, $title->getFiles());
        $title->addFile($fileOne);
        self::assertCount(1, $title->getFiles());
        $title->addFile($fileTwo);
        self::assertCount(2, $title->getFiles());
        $title->removeFile($fileOne);
        self::assertCount(1, $title->getFiles());
        $title->removeFile($fileOne);
        self::assertCount(1, $title->getFiles());

        $tagFoo = new Tag();
        $tagFoo->setName('tag:foo');
        $tagBar = new Tag();
        $tagBar->setName('tag:bar');
        $title->addTag($tagFoo);
        self::assertCount(1, $title->getTags());
        $title->addTag($tagFoo);
        self::assertCount(1, $title->getTags());
        $title->addTag($tagBar);
        self::assertCount(2, $title->getTags());
        $title->removeTag($tagFoo);
        self::assertCount(1, $title->getTags());
        $title->removeTag($tagFoo);
        self::assertCount(1, $title->getTags());
    }
}
