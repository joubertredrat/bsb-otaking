<?php

declare(strict_types=1);

namespace App\Tests\UseCase;

use App\Dto\CreateTitle as DtoCreateTitle;
use App\Entity\Fansub;
use App\Entity\Tag;
use App\Exception\UseCase\CreateTitle\FansubsNotFoundException;
use App\Exception\UseCase\CreateTitle\TagsNotFoundException;
use App\Repository\FansubRepositoryInterface;
use App\Repository\TagRepositoryInterface;
use App\Repository\TitleRepositoryInterface;
use App\UseCase\CreateTitle;
use Mockery;
use PHPUnit\Framework\TestCase;

class CreateTitleTest extends TestCase
{
    public function testCreateTitleWithSuccess(): void
    {
        $dtoCreateTitle = new DtoCreateTitle(
            name: 'Super Foo',
            alternativeNames: [],
            type: DtoCreateTitle::TYPE_2D,
            language: DtoCreateTitle::LANGUAGE_PT_BR,
            episodes: 2,
            statusDownload: DtoCreateTitle::STATUS_DOWNLOAD_COMPLETE,
            statusView: DtoCreateTitle::STATUS_VIEW_DONE,
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

        $tag = new Tag();
        $tag->setName('foo:bar');

        $tagRepository = Mockery::mock(TagRepositoryInterface::class);
        $tagRepository
            ->shouldReceive('get')
            ->withArgs([2])
            ->andReturn($tag)
        ;

        $titleRepository = Mockery::mock(TitleRepositoryInterface::class);
        $titleRepository
            ->shouldReceive('save')
            ->once()
        ;

        $createTitle = new CreateTitle(
            titleRepository: $titleRepository,
            fansubRepository: $fansubRepository,
            tagRepository: $tagRepository,
        );

        $titleGot = $createTitle->execute($dtoCreateTitle);

        self::assertEquals($dtoCreateTitle->name, $titleGot->getName());
        self::assertEquals($dtoCreateTitle->alternativeNames, $titleGot->getAlternativeNames());
        self::assertEquals($dtoCreateTitle->type, $titleGot->getType());
        self::assertEquals($dtoCreateTitle->language, $titleGot->getLanguage());
        self::assertEquals($dtoCreateTitle->episodes, $titleGot->getEpisodes());
        self::assertEquals($dtoCreateTitle->statusDownload, $titleGot->getStatusDownload());
        self::assertEquals($dtoCreateTitle->statusView, $titleGot->getStatusView());
        self::assertCount(1, $titleGot->getFansubs());
        self::assertCount(2, $titleGot->getFiles());
        self::assertCount(1, $titleGot->getTags());
    }

    public function testCreateTitleWithFansubNotFound(): void
    {
        $this->expectException(FansubsNotFoundException::class);

        $dtoCreateTitle = new DtoCreateTitle(
            name: 'Super Foo',
            alternativeNames: [],
            type: DtoCreateTitle::TYPE_2D,
            language: DtoCreateTitle::LANGUAGE_PT_BR,
            episodes: 2,
            statusDownload: DtoCreateTitle::STATUS_DOWNLOAD_COMPLETE,
            statusView: DtoCreateTitle::STATUS_VIEW_DONE,
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
        $titleRepository = Mockery::mock(TitleRepositoryInterface::class);

        $createTitle = new CreateTitle(
            titleRepository: $titleRepository,
            fansubRepository: $fansubRepository,
            tagRepository: $tagRepository,
        );

        $createTitle->execute($dtoCreateTitle);
    }

    public function testCreateTitleWithTagNotFound(): void
    {
        $this->expectException(TagsNotFoundException::class);

        $dtoCreateTitle = new DtoCreateTitle(
            name: 'Super Foo',
            alternativeNames: [],
            type: DtoCreateTitle::TYPE_2D,
            language: DtoCreateTitle::LANGUAGE_PT_BR,
            episodes: 2,
            statusDownload: DtoCreateTitle::STATUS_DOWNLOAD_COMPLETE,
            statusView: DtoCreateTitle::STATUS_VIEW_DONE,
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

        $titleRepository = Mockery::mock(TitleRepositoryInterface::class);

        $createTitle = new CreateTitle(
            titleRepository: $titleRepository,
            fansubRepository: $fansubRepository,
            tagRepository: $tagRepository,
        );

        $createTitle->execute($dtoCreateTitle);
    }
}
