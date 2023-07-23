<?php

declare(strict_types=1);

namespace App\Tests\Dto;

use App\Dto\CreateHentaiTitle;
use App\Entity\HentaiTitle;
use App\Exception\Dto\CreateHentaiTitle\InvalidArgumentsException;
use App\Tests\Helper;
use PHPUnit\Framework\TestCase;

class CreateHentaiTitleTest extends TestCase
{
    public function testCreateHentaiTitle(): void
    {
        $nameExpected = 'Super Foo';
        $alternativeNamesExpected = [];
        $typeExpected = HentaiTitle::TYPE_2D;
        $languageExpected = HentaiTitle::LANGUAGE_PT_BR;
        $episodesExpected = 2;
        $statusDownloadExpected = HentaiTitle::STATUS_DOWNLOAD_COMPLETE;
        $statusViewExpected = HentaiTitle::STATUS_VIEW_DONE;
        $fansubsExpected = [1, 2, 3];
        $videoFilesExpected = Helper::getVideoFiles();
        $tagsExpected = [4];

        $createHentaiTitle = new CreateHentaiTitle(
            name: $nameExpected,
            alternativeNames: $alternativeNamesExpected,
            type: $typeExpected,
            language: $languageExpected,
            episodes: $episodesExpected,
            statusDownload: $statusDownloadExpected,
            statusView: $statusViewExpected,
            fansubs: $fansubsExpected,
            tags: $tagsExpected,
            videoFiles: $videoFilesExpected,
        );

        self::assertEquals($nameExpected, $createHentaiTitle->name);
        self::assertEquals($alternativeNamesExpected, $createHentaiTitle->alternativeNames);
        self::assertEquals($typeExpected, $createHentaiTitle->type);
        self::assertEquals($languageExpected, $createHentaiTitle->language);
        self::assertEquals($episodesExpected, $createHentaiTitle->episodes);
        self::assertEquals($statusDownloadExpected, $createHentaiTitle->statusDownload);
        self::assertEquals($statusViewExpected, $createHentaiTitle->statusView);
        self::assertEquals($videoFilesExpected, $createHentaiTitle->videoFiles);
        self::assertEquals($tagsExpected, $createHentaiTitle->tags);
    }

    public function testCreateHentaiTitleWithInvalidArguments(): void
    {
        $this->expectException(InvalidArgumentsException::class);

        new CreateHentaiTitle(
            name: '',
            alternativeNames: [],
            type: '4D',
            language: 'ru_ru',
            episodes: -1,
            statusDownload: 'unknown',
            statusView: 'unknown',
            fansubs: [1, 0, 2, 3],
            tags: [0],
            videoFiles: ['Ep1.mkv', 'Ep2.mkv'],
        );
    }
}
