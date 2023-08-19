<?php

declare(strict_types=1);

namespace App\Tests\Unit\UseCase;

use App\Entity\HentaiTitle;
use App\Exception\UseCase\GetHentaiTitle\HentaiTitleNotFoundException;
use App\Repository\HentaiTitleRepositoryInterface;
use App\UseCase\GetHentaiTitle;
use Mockery;
use PHPUnit\Framework\TestCase;

class GetHentaiTitleTest extends TestCase
{
    public function testGetHentaiTitleWithSuccess(): void
    {
        $hentaiTitleExpected = new HentaiTitle();
        $hentaiTitleExpected->setName('Super Foo');

        $id = 10;

        $hentaiTitleRepository = Mockery::mock(HentaiTitleRepositoryInterface::class);
        $hentaiTitleRepository
            ->shouldReceive('get')
            ->withArgs([$id])
            ->andReturn($hentaiTitleExpected)
        ;

        $getHentaiTitle = new GetHentaiTitle($hentaiTitleRepository);
        $hentaiTitleGot = $getHentaiTitle->execute($id);

        self::assertEquals($hentaiTitleExpected, $hentaiTitleGot);
    }

    public function testGetHentaiTitleWithHentaiTitleNotFoundException(): void
    {
        $this->expectException(HentaiTitleNotFoundException::class);

        $id = 12;

        $hentaiTitleRepository = Mockery::mock(HentaiTitleRepositoryInterface::class);
        $hentaiTitleRepository
            ->shouldReceive('get')
            ->withArgs([$id])
            ->andReturn(null)
        ;

        $getHentaiTitle = new GetHentaiTitle($hentaiTitleRepository);
        $getHentaiTitle->execute($id);
    }
}
