<?php

declare(strict_types=1);

namespace App\Tests\Unit\Dto;

use App\Dto\EditHentaiTitle;
use App\Entity\HentaiTitle;
use App\Exception\Dto\EditHentaiTitle\InvalidArgumentsException;
use App\Tests\Helper;
use PHPUnit\Framework\TestCase;

class EditHentaiTitleTest extends TestCase
{
    public function testEditHentaiTitle(): void
    {
        $idExpected = 10;
        $nameExpected = 'Super Foo';
        $alternativeNamesExpected = [];
        $typeExpected = HentaiTitle::TYPE_2D;
        $languageExpected = HentaiTitle::LANGUAGE_PT_BR;
        $episodesExpected = 2;
        $ratingExpected = 4;
        $statusDownloadExpected = HentaiTitle::STATUS_DOWNLOAD_COMPLETE;
        $statusViewExpected = HentaiTitle::STATUS_VIEW_DONE;
        $fansubsExpected = [1, 2, 3];
        $videoFilesExpected = Helper::getVideoFiles();
        $tagsExpected = [4];

        $editHentaiTitle = new EditHentaiTitle(
            id: $idExpected,
            name: $nameExpected,
            alternativeNames: $alternativeNamesExpected,
            type: $typeExpected,
            language: $languageExpected,
            episodes: $episodesExpected,
            rating: $ratingExpected,
            statusDownload: $statusDownloadExpected,
            statusView: $statusViewExpected,
            fansubs: $fansubsExpected,
            tags: $tagsExpected,
            videoFiles: $videoFilesExpected,
        );

        self::assertEquals($idExpected, $editHentaiTitle->id);
        self::assertEquals($nameExpected, $editHentaiTitle->name);
        self::assertEquals($alternativeNamesExpected, $editHentaiTitle->alternativeNames);
        self::assertEquals($typeExpected, $editHentaiTitle->type);
        self::assertEquals($languageExpected, $editHentaiTitle->language);
        self::assertEquals($episodesExpected, $editHentaiTitle->episodes);
        self::assertEquals($ratingExpected, $editHentaiTitle->rating);
        self::assertEquals($statusDownloadExpected, $editHentaiTitle->statusDownload);
        self::assertEquals($statusViewExpected, $editHentaiTitle->statusView);
        self::assertEquals($videoFilesExpected, $editHentaiTitle->videoFiles);
        self::assertEquals($tagsExpected, $editHentaiTitle->tags);
    }

    public function testEditHentaiTitleWithInvalidArguments(): void
    {
        $this->expectException(InvalidArgumentsException::class);

        new EditHentaiTitle(
            id: -10,
            name: '',
            alternativeNames: [],
            type: '4D',
            language: 'ru_ru',
            episodes: -1,
            rating: 16,
            statusDownload: 'unknown',
            statusView: 'unknown',
            fansubs: [1, 0, 2, 3],
            tags: [0],
            videoFiles: ['Ep1.mkv', 'Ep2.mkv'],
        );
    }
}
