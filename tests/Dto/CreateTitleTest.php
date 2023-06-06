<?php

declare(strict_types=1);

namespace App\Tests\Dto;

use App\Dto\CreateTitle;
use App\Exception\Dto\CreateTitle\InvalidArgumentsException;
use PHPUnit\Framework\TestCase;

class CreateTitleTest extends TestCase
{
    public function testCreateTitle(): void
    {
        $nameExpected = 'Super Foo';
        $alternativeNamesExpected = [];
        $typeExpected = CreateTitle::TYPE_2D;
        $languageExpected = CreateTitle::LANGUAGE_PT_BR;
        $episodesExpected = 2;
        $statusDownloadExpected = CreateTitle::STATUS_DOWNLOAD_COMPLETE;
        $statusViewExpected = CreateTitle::STATUS_VIEW_DONE;
        $fansubsExpected = [1, 2, 3];
        $filesExpected = ['Ep1.mkv', 'Ep2.mkv'];
        $tagsExpected = [4];

        $createTitle = new CreateTitle(
            name: $nameExpected,
            alternativeNames: $alternativeNamesExpected,
            type: $typeExpected,
            language: $languageExpected,
            episodes: $episodesExpected,
            statusDownload: $statusDownloadExpected,
            statusView: $statusViewExpected,
            fansubs: $fansubsExpected,
            files: $filesExpected,
            tags: $tagsExpected,
        );

        self::assertEquals($nameExpected, $createTitle->name);
        self::assertEquals($alternativeNamesExpected, $createTitle->alternativeNames);
        self::assertEquals($typeExpected, $createTitle->type);
        self::assertEquals($languageExpected, $createTitle->language);
        self::assertEquals($episodesExpected, $createTitle->episodes);
        self::assertEquals($statusDownloadExpected, $createTitle->statusDownload);
        self::assertEquals($statusViewExpected, $createTitle->statusView);
        self::assertEquals($filesExpected, $createTitle->files);
        self::assertEquals($tagsExpected, $createTitle->tags);
    }

    public function testCreateTitleWithInvalidArguments(): void
    {
        $this->expectException(InvalidArgumentsException::class);

        new CreateTitle(
            name: '',
            alternativeNames: [],
            type: '4D',
            language: 'ru_ru',
            episodes: -1,
            statusDownload: 'unknown',
            statusView: 'unknown',
            fansubs: [1, 0, 2, 3],
            files: ['Ep1.mkv', 'Ep2.mkv'],
            tags: [0],
        );
    }
}
