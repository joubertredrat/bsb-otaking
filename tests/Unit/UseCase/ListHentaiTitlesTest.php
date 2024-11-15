<?php

declare(strict_types=1);

namespace App\Tests\Unit\UseCase;

use App\Dto\ListHentaiTitles as DtoListHentaiTitles;
use App\Dto\Pagination;
use App\Entity\HentaiTitle;
use App\Repository\HentaiTitleRepositoryInterface;
use App\UseCase\ListHentaiTitles;
use Mockery;
use PHPUnit\Framework\TestCase;

class ListHentaiTitlesTest extends TestCase
{
    public function testListHentaiTitlesWithSuccess(): void
    {
        $dtoListHentaiTitles = new DtoListHentaiTitles(
            pagination: new Pagination(1, 10),
            searchCriteria: '',
            type: '',
            language: '',
            rating: 0,
            statusDownload: '',
            statusView: '',
            fansubId: 0,
            tagId: 0,
        );

        $hentaiTitleFoo = new HentaiTitle();
        $hentaiTitleFoo->setName('Super Foo');
        $hentaiTitleBar = new HentaiTitle();
        $hentaiTitleBar->setName('Extreme Bar');

        $hentaiTitlesExpected = [$hentaiTitleFoo, $hentaiTitleBar];
        $totalExpected = 2;

        $hentaiTitleRepository = Mockery::mock(HentaiTitleRepositoryInterface::class);
        $hentaiTitleRepository
            ->shouldReceive('list')
            ->andReturn($hentaiTitlesExpected)
        ;
        $hentaiTitleRepository
            ->shouldReceive('countAll')
            ->andReturn($totalExpected)
        ;

        /** @var HentaiTitleRepositoryInterface $hentaiTitleRepository */
        $listTitles = new ListHentaiTitles($hentaiTitleRepository);
        $hentaiTitlesGot = $listTitles->execute($dtoListHentaiTitles);

        self::assertEquals($hentaiTitlesExpected, $hentaiTitlesGot->items);
        self::assertEquals($totalExpected, $hentaiTitlesGot->total->value);
    }
}
