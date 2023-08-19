<?php

declare(strict_types=1);

namespace App\Tests\Unit\Entity;

use App\Entity\Fansub;
use App\Entity\HentaiTitle;
use App\Entity\Tag;
use App\Entity\VideoFile;
use App\Exception\Entity\HentaiTitle\InvalidEpisodesException;
use App\Exception\Entity\HentaiTitle\InvalidLanguageException;
use App\Exception\Entity\HentaiTitle\InvalidRatingException;
use App\Exception\Entity\HentaiTitle\InvalidStatusDownloadException;
use App\Exception\Entity\HentaiTitle\InvalidStatusViewException;
use App\Exception\Entity\HentaiTitle\InvalidTypeException;
use App\Tests\Helper;
use PHPUnit\Framework\TestCase;

class HentaiTitleTest extends TestCase
{
    public function testAttributes(): void
    {
        $idExpected = 10;
        $nameExpected = 'Foo';
        $alternativeNamesExpected = [];
        $typeExpected = HentaiTitle::TYPE_2D;
        $languageExpected = HentaiTitle::LANGUAGE_PT_BR;
        $episodesExpected = 2;
        $ratingExpected = 4;
        $statusDownloadExpected = HentaiTitle::STATUS_DOWNLOAD_COMPLETE;
        $statusViewExpected = HentaiTitle::STATUS_VIEW_DONE;

        $hentaiTitle = new HentaiTitle();

        self::assertNull($hentaiTitle->getId());
        self::assertNull($hentaiTitle->getName());
        self::assertCount(0, $hentaiTitle->getAlternativeNames());
        self::assertNull($hentaiTitle->getType());
        self::assertNull($hentaiTitle->getLanguage());
        self::assertNull($hentaiTitle->getEpisodes());
        self::assertNull($hentaiTitle->getRating());
        self::assertNull($hentaiTitle->getStatusDownload());
        self::assertNull($hentaiTitle->getStatusView());
        self::assertCount(0, $hentaiTitle->getFansubs());
        self::assertCount(0, $hentaiTitle->getVideoFiles());
        self::assertCount(0, $hentaiTitle->getTags());

        $hentaiTitle->setId($idExpected);
        $hentaiTitle->setName($nameExpected);
        $hentaiTitle->setAlternativeNames($alternativeNamesExpected);
        $hentaiTitle->setType($typeExpected);
        $hentaiTitle->setLanguage($languageExpected);
        $hentaiTitle->setEpisodes($episodesExpected);
        $hentaiTitle->setRating($ratingExpected);
        $hentaiTitle->setStatusDownload($statusDownloadExpected);
        $hentaiTitle->setStatusView($statusViewExpected);

        self::assertEquals($idExpected, $hentaiTitle->getId());
        self::assertEquals($nameExpected, $hentaiTitle->getName());
        self::assertEquals($alternativeNamesExpected, $hentaiTitle->getAlternativeNames());
        self::assertEquals($typeExpected, $hentaiTitle->getType());
        self::assertEquals($languageExpected, $hentaiTitle->getLanguage());
        self::assertEquals($episodesExpected, $hentaiTitle->getEpisodes());
        self::assertEquals($ratingExpected, $hentaiTitle->getRating());
        self::assertEquals($statusDownloadExpected, $hentaiTitle->getStatusDownload());
        self::assertEquals($statusViewExpected, $hentaiTitle->getStatusView());

        $fansubFoo = (new Fansub())->setName('Foo');
        $fansubBar = (new Fansub())->setName('Bar');
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

        $videoFileOne = (new VideoFile())->setName(Helper::VIDEOFILE_01);
        $videoFileTwo = (new VideoFile())->setName(Helper::VIDEOFILE_02);
        $hentaiTitle->addVideoFile($videoFileOne);
        self::assertCount(1, $hentaiTitle->getVideoFiles());
        $hentaiTitle->addVideoFile($videoFileOne);
        self::assertCount(1, $hentaiTitle->getVideoFiles());
        $hentaiTitle->addVideoFile($videoFileTwo);
        self::assertCount(2, $hentaiTitle->getVideoFiles());
        $hentaiTitle->removeVideoFile($videoFileOne);
        self::assertCount(1, $hentaiTitle->getVideoFiles());
        $hentaiTitle->removeVideoFile($videoFileOne);
        self::assertCount(1, $hentaiTitle->getVideoFiles());

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

    public function testAttributesWithInvalidType(): void
    {
        $this->expectException(InvalidTypeException::class);

        (new HentaiTitle())->setType('foo');
    }

    public function testAttributesWithInvalidLanguage(): void
    {
        $this->expectException(InvalidLanguageException::class);

        (new HentaiTitle())->setLanguage('foo');
    }

    public function testAttributesWithInvalidEpisodes(): void
    {
        $this->expectException(InvalidEpisodesException::class);

        (new HentaiTitle())->setEpisodes(-1);
    }

    public function testAttributesWithInvalidRating(): void
    {
        $this->expectException(InvalidRatingException::class);

        (new HentaiTitle())->setRating(16);
    }

    public function testAttributesWithInvalidStatusDownload(): void
    {
        $this->expectException(InvalidStatusDownloadException::class);

        (new HentaiTitle())->setStatusDownload('foo');
    }

    public function testAttributesWithInvalidStatusView(): void
    {
        $this->expectException(InvalidStatusViewException::class);

        (new HentaiTitle())->setStatusView('foo');
    }
}
