<?php

declare(strict_types=1);

namespace App\Tests\UseCase;

use App\Entity\HentaiTitle;
use App\Repository\HentaiTitleRepositoryInterface;
use App\UseCase\ListHentaiTitles;
use Mockery;
use PHPUnit\Framework\TestCase;

class ListHentaiTitlesTest extends TestCase
{
    public function testListHentaiTitlesWithSuccess(): void
    {
        $hentaiTitleFoo = new HentaiTitle();
        $hentaiTitleFoo->setName('Super Foo');
        $hentaiTitleBar = new HentaiTitle();
        $hentaiTitleBar->setName('Extreme Bar');

        $hentaiTitlesExpected = [$hentaiTitleFoo, $hentaiTitleBar];

        $hentaiTitleRepository = Mockery::mock(HentaiTitleRepositoryInterface::class);
        $hentaiTitleRepository
            ->shouldReceive('list')
            ->andReturn($hentaiTitlesExpected)
        ;

        $listTitles = new ListHentaiTitles($hentaiTitleRepository);
        $hentaiTitlesGot = $listTitles->execute();

        self::assertEquals($hentaiTitlesExpected, $hentaiTitlesGot);
    }
}
