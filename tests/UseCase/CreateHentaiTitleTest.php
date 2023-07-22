<?php

declare(strict_types=1);

namespace App\Tests\UseCase;

use App\Dto\CreateHentaiTitle as DtoCreateHentaiTitle;
use App\Entity\Fansub;
use App\Entity\Tag;
use App\Exception\UseCase\CreateHentaiTitle\FansubsNotFoundException;
use App\Exception\UseCase\CreateHentaiTitle\TagsNotFoundException;
use App\Repository\FansubRepositoryInterface;
use App\Repository\HentaiTitleRepositoryInterface;
use App\Repository\TagRepositoryInterface;
use App\UseCase\CreateHentaiTitle;
use Mockery;
use PHPUnit\Framework\TestCase;

class CreateHentaiTitleTest extends TestCase
{
    public function testCreateHentaiTitleWithSuccess(): void
    {
        $dtoCreateHentaiTitle = new DtoCreateHentaiTitle(
            name: 'Super Foo',
            alternativeNames: [],
            type: DtoCreateHentaiTitle::TYPE_2D,
            language: DtoCreateHentaiTitle::LANGUAGE_PT_BR,
            episodes: 2,
            statusDownload: DtoCreateHentaiTitle::STATUS_DOWNLOAD_COMPLETE,
            statusView: DtoCreateHentaiTitle::STATUS_VIEW_DONE,
            fansubs: [1],
            files: ['Ep1.mkv', 'Ep2.mkv'],
            tags: [2],
        );

        $fansub = new Fansub();
        $fansub->setName('Foo Fansub');

        $fansubRepository = Mockery::mock(FansubRepositoryInterface::class);
        $fansubRepository
            ->shouldReceive('get')
            ->withArgs([1])
            ->andReturn($fansub)
        ;

        $tag = (new Tag())
            ->setType(Tag::TYPE_ALL)
            ->setName('foo')
        ;

        $tagRepository = Mockery::mock(TagRepositoryInterface::class);
        $tagRepository
            ->shouldReceive('get')
            ->withArgs([2])
            ->andReturn($tag)
        ;

        $hentaiTitleRepository = Mockery::mock(HentaiTitleRepositoryInterface::class);
        $hentaiTitleRepository
            ->shouldReceive('save')
            ->once()
        ;

        $usecase = new CreateHentaiTitle(
            fansubRepository: $fansubRepository,
            hentaiTitleRepository: $hentaiTitleRepository,
            tagRepository: $tagRepository,
        );

        $hentaiTitleGot = $usecase->execute($dtoCreateHentaiTitle);

        self::assertEquals($dtoCreateHentaiTitle->name, $hentaiTitleGot->getName());
        self::assertEquals($dtoCreateHentaiTitle->alternativeNames, $hentaiTitleGot->getAlternativeNames());
        self::assertEquals($dtoCreateHentaiTitle->type, $hentaiTitleGot->getType());
        self::assertEquals($dtoCreateHentaiTitle->language, $hentaiTitleGot->getLanguage());
        self::assertEquals($dtoCreateHentaiTitle->episodes, $hentaiTitleGot->getEpisodes());
        self::assertEquals($dtoCreateHentaiTitle->statusDownload, $hentaiTitleGot->getStatusDownload());
        self::assertEquals($dtoCreateHentaiTitle->statusView, $hentaiTitleGot->getStatusView());
        self::assertCount(1, $hentaiTitleGot->getFansubs());
        self::assertCount(2, $hentaiTitleGot->getFiles());
        self::assertCount(1, $hentaiTitleGot->getTags());
    }

    public function testCreateHentaiTitleWithFansubNotFound(): void
    {
        $this->expectException(FansubsNotFoundException::class);

        $dtoCreateHentaiTitle = new DtoCreateHentaiTitle(
            name: 'Super Foo',
            alternativeNames: [],
            type: DtoCreateHentaiTitle::TYPE_2D,
            language: DtoCreateHentaiTitle::LANGUAGE_PT_BR,
            episodes: 2,
            statusDownload: DtoCreateHentaiTitle::STATUS_DOWNLOAD_COMPLETE,
            statusView: DtoCreateHentaiTitle::STATUS_VIEW_DONE,
            fansubs: [7],
            files: ['Ep1.mkv', 'Ep2.mkv'],
            tags: [2],
        );

        $fansubRepository = Mockery::mock(FansubRepositoryInterface::class);
        $fansubRepository
            ->shouldReceive('get')
            ->withArgs([7])
            ->andReturn(null)
        ;

        $tagRepository = Mockery::mock(TagRepositoryInterface::class);
        $hentaiTitleRepository = Mockery::mock(HentaiTitleRepositoryInterface::class);

        $usecase = new CreateHentaiTitle(
            fansubRepository: $fansubRepository,
            hentaiTitleRepository: $hentaiTitleRepository,
            tagRepository: $tagRepository,
        );

        $usecase->execute($dtoCreateHentaiTitle);
    }

    public function testCreateHentaiTitleWithTagNotFound(): void
    {
        $this->expectException(TagsNotFoundException::class);

        $dtoCreateHentaiTitle = new DtoCreateHentaiTitle(
            name: 'Super Foo',
            alternativeNames: [],
            type: DtoCreateHentaiTitle::TYPE_2D,
            language: DtoCreateHentaiTitle::LANGUAGE_PT_BR,
            episodes: 2,
            statusDownload: DtoCreateHentaiTitle::STATUS_DOWNLOAD_COMPLETE,
            statusView: DtoCreateHentaiTitle::STATUS_VIEW_DONE,
            fansubs: [1],
            files: ['Ep1.mkv', 'Ep2.mkv'],
            tags: [8],
        );

        $fansub = new Fansub();
        $fansub->setName('Foo Fansub');

        $fansubRepository = Mockery::mock(FansubRepositoryInterface::class);
        $fansubRepository
            ->shouldReceive('get')
            ->withArgs([1])
            ->andReturn($fansub)
        ;

        $tagRepository = Mockery::mock(TagRepositoryInterface::class);
        $tagRepository
            ->shouldReceive('get')
            ->withArgs([8])
            ->andReturn(null)
        ;

        $hentaiTitleRepository = Mockery::mock(HentaiTitleRepositoryInterface::class);

        $usecase = new CreateHentaiTitle(
            fansubRepository: $fansubRepository,
            hentaiTitleRepository: $hentaiTitleRepository,
            tagRepository: $tagRepository,
        );

        $usecase->execute($dtoCreateHentaiTitle);
    }
}