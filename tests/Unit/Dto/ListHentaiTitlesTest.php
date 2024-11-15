<?php

declare(strict_types=1);

namespace App\Tests\Unit\Dto;

use App\Dto\ListHentaiTitles;
use App\Dto\Pagination;
use App\Entity\HentaiTitle;
use PHPUnit\Framework\TestCase;

class ListHentaiTitlesTest extends TestCase
{
    public function testListHentaiTitles(): void
    {
        $paginationExpected = new Pagination(1, 10);
        $searchCriteriaExpected = 'Foo';
        $typeExpected = HentaiTitle::TYPE_2D;
        $languageExpected = HentaiTitle::LANGUAGE_EN_US;
        $ratingExpected = 4;
        $statusDownloadExpected = HentaiTitle::STATUS_DOWNLOAD_COMPLETE;
        $statusViewExpected = HentaiTitle::STATUS_VIEW_DONE;
        $fansubIdExpected = 10;
        $tagIdExpected = 15;

        $listHentaiTitles = new ListHentaiTitles(
            pagination: $paginationExpected,
            searchCriteria: $searchCriteriaExpected,
            type: $typeExpected,
            language: $languageExpected,
            rating: $ratingExpected,
            statusDownload: $statusDownloadExpected,
            statusView: $statusViewExpected,
            fansubId: $fansubIdExpected,
            tagId: $tagIdExpected,
        );

        self::assertEquals($paginationExpected, $listHentaiTitles->pagination);
        self::assertEquals($searchCriteriaExpected, $listHentaiTitles->searchCriteria);
        self::assertEquals($typeExpected, $listHentaiTitles->type);
        self::assertEquals($languageExpected, $listHentaiTitles->language);
        self::assertEquals($ratingExpected, $listHentaiTitles->rating);
        self::assertEquals($statusDownloadExpected, $listHentaiTitles->statusDownload);
        self::assertEquals($statusViewExpected, $listHentaiTitles->statusView);
        self::assertEquals($fansubIdExpected, $listHentaiTitles->fansubId);
        self::assertEquals($tagIdExpected, $listHentaiTitles->tagId);
    }
}
