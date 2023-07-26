<?php

declare(strict_types=1);

namespace App\Tests\UseCase;

use App\Dto\EditHentaiTitle as DtoEditHentaiTitle;
use App\Entity\Fansub;
use App\Entity\HentaiTitle;
use App\Entity\Tag;
use App\Entity\VideoFile;
use App\Exception\UseCase\EditHentaiTitle\FansubsNotFoundException;
use App\Exception\UseCase\EditHentaiTitle\HentaiTitleNotFoundException;
use App\Exception\UseCase\EditHentaiTitle\TagsNotFoundException;
use App\Repository\FansubRepositoryInterface;
use App\Repository\HentaiTitleRepositoryInterface;
use App\Repository\TagRepositoryInterface;
use App\Repository\VideoFileRepositoryInterface;
use App\Tests\Helper;
use App\UseCase\EditHentaiTitle;
use DateTimeImmutable;
use Mockery;
use PHPUnit\Framework\TestCase;

class EditHentaiTitleTest extends TestCase
{
    public function testEditHentaiTitleWithSuccess(): void
    {
        $dtoEditHentaiTitle = new DtoEditHentaiTitle(
            id: 10,
            name: 'Super Foo',
            alternativeNames: [],
            type: HentaiTitle::TYPE_2D,
            language: HentaiTitle::LANGUAGE_PT_BR,
            episodes: 2,
            statusDownload: HentaiTitle::STATUS_DOWNLOAD_COMPLETE,
            statusView: HentaiTitle::STATUS_VIEW_DONE,
            fansubs: [1, 4],
            tags: [2, 3],
            videoFiles: [
                Helper::VIDEOFILE_01_V2,
                Helper::VIDEOFILE_02,
            ],
        );

        $fansubOne = (new Fansub())->setId(1)->setName('One Fansub');
        $fansubTwo = (new Fansub())->setId(2)->setName('Two Fansub');
        $fansubFour = (new Fansub())->setId(4)->setName('Four Fansub');

        $tagOne = (new Tag())->setId(1)->setType(Tag::TYPE_ALL)->setName('one');
        $tagTwo = (new Tag())->setId(2)->setType(Tag::TYPE_ALL)->setName('two');
        $tagThree = (new Tag())->setId(3)->setType(Tag::TYPE_ALL)->setName('three');

        $videoFileOne = (new VideoFile())->setName(Helper::VIDEOFILE_01)->setCreatedAtNow();
        $videoFileTwo = (new VideoFile())->setName(Helper::VIDEOFILE_02)->setCreatedAtNow();

        $hentaiTitle = (new HentaiTitle())
            ->setId($dtoEditHentaiTitle->id)
            ->setName('Title Foo')
            ->setAlternativeNames(['ほげ'])
            ->setType(HentaiTitle::TYPE_2D)
            ->setLanguage(HentaiTitle::LANGUAGE_PT_BR)
            ->setEpisodes(2)
            ->setStatusDownload(HentaiTitle::STATUS_DOWNLOAD_COMPLETE)
            ->setStatusView(HentaiTitle::STATUS_VIEW_DONE)
            ->addFansub($fansubOne)
            ->addFansub($fansubTwo)
            ->addTag($tagOne)
            ->addTag($tagTwo)
            ->addVideoFile($videoFileOne)
            ->addVideoFile($videoFileTwo)
            ->setCreatedAt(new DateTimeImmutable('2023-06-29 19:18:17'))
        ;

        $hentaiTitleRepository = Mockery::mock(HentaiTitleRepositoryInterface::class);
        $hentaiTitleRepository
            ->shouldReceive('get')
            ->withArgs([$dtoEditHentaiTitle->id])
            ->andReturn($hentaiTitle)
            ->once()
        ;
        $hentaiTitleRepository
            ->shouldReceive('save')
            ->once()
        ;

        $videoFileRepository = Mockery::mock(VideoFileRepositoryInterface::class);
        $videoFileRepository
            ->shouldReceive('removeByList')
            ->once()
        ;

        $fansubRepository = Mockery::mock(FansubRepositoryInterface::class);
        $fansubRepository
            ->shouldReceive('get')
            ->withArgs([1])
            ->andReturn($fansubOne)
        ;
        $fansubRepository
            ->shouldReceive('get')
            ->withArgs([4])
            ->andReturn($fansubFour)
        ;

        $tagRepository = Mockery::mock(TagRepositoryInterface::class);
        $tagRepository
            ->shouldReceive('get')
            ->withArgs([2])
            ->andReturn($tagTwo)
        ;
        $tagRepository
            ->shouldReceive('get')
            ->withArgs([3])
            ->andReturn($tagThree)
        ;

        $usecase = new EditHentaiTitle(
            fansubRepository: $fansubRepository,
            tagRepository: $tagRepository,
            hentaiTitleRepository: $hentaiTitleRepository,
            videoFileRepository: $videoFileRepository,
        );

        $hentaiTitleGot = $usecase->execute($dtoEditHentaiTitle);

        self::assertEquals($dtoEditHentaiTitle->id, $hentaiTitleGot->getId());
        self::assertEquals($dtoEditHentaiTitle->name, $hentaiTitleGot->getName());
        self::assertEquals($dtoEditHentaiTitle->alternativeNames, $hentaiTitleGot->getAlternativeNames());
        self::assertEquals($dtoEditHentaiTitle->type, $hentaiTitleGot->getType());
        self::assertEquals($dtoEditHentaiTitle->language, $hentaiTitleGot->getLanguage());
        self::assertEquals($dtoEditHentaiTitle->episodes, $hentaiTitleGot->getEpisodes());
        self::assertEquals($dtoEditHentaiTitle->statusDownload, $hentaiTitleGot->getStatusDownload());
        self::assertEquals($dtoEditHentaiTitle->statusView, $hentaiTitleGot->getStatusView());
        self::assertCount(2, $hentaiTitleGot->getFansubs());
        self::assertCount(2, $hentaiTitleGot->getVideoFiles());
        self::assertCount(2, $hentaiTitleGot->getTags());
    }

    public function testEditHentaiTitleWithSuccessAndNoNewVideoFiles(): void
    {
        $dtoEditHentaiTitle = new DtoEditHentaiTitle(
            id: 10,
            name: 'Super Foo',
            alternativeNames: [],
            type: HentaiTitle::TYPE_2D,
            language: HentaiTitle::LANGUAGE_PT_BR,
            episodes: 2,
            statusDownload: HentaiTitle::STATUS_DOWNLOAD_COMPLETE,
            statusView: HentaiTitle::STATUS_VIEW_DONE,
            fansubs: [1, 2],
            tags: [1, 2],
            videoFiles: [],
        );

        $fansubOne = (new Fansub())->setId(1)->setName('One Fansub');
        $fansubTwo = (new Fansub())->setId(2)->setName('Two Fansub');

        $tagOne = (new Tag())->setId(1)->setType(Tag::TYPE_ALL)->setName('one');
        $tagTwo = (new Tag())->setId(2)->setType(Tag::TYPE_ALL)->setName('two');

        $hentaiTitle = (new HentaiTitle())
            ->setId($dtoEditHentaiTitle->id)
            ->setName('Title Foo')
            ->setAlternativeNames(['ほげ'])
            ->setType(HentaiTitle::TYPE_2D)
            ->setLanguage(HentaiTitle::LANGUAGE_PT_BR)
            ->setEpisodes(2)
            ->setStatusDownload(HentaiTitle::STATUS_DOWNLOAD_COMPLETE)
            ->setStatusView(HentaiTitle::STATUS_VIEW_DONE)
            ->addFansub($fansubOne)
            ->addFansub($fansubTwo)
            ->addTag($tagOne)
            ->addTag($tagTwo)
            ->setCreatedAt(new DateTimeImmutable('2023-06-29 19:18:17'))
        ;

        $hentaiTitleRepository = Mockery::mock(HentaiTitleRepositoryInterface::class);
        $hentaiTitleRepository
            ->shouldReceive('get')
            ->withArgs([$dtoEditHentaiTitle->id])
            ->andReturn($hentaiTitle)
            ->once()
        ;
        $hentaiTitleRepository
            ->shouldReceive('save')
            ->once()
        ;

        $videoFileRepository = Mockery::mock(VideoFileRepositoryInterface::class);

        $fansubRepository = Mockery::mock(FansubRepositoryInterface::class);
        $fansubRepository
            ->shouldReceive('get')
            ->withArgs([1])
            ->andReturn($fansubOne)
        ;
        $fansubRepository
            ->shouldReceive('get')
            ->withArgs([2])
            ->andReturn($fansubTwo)
        ;

        $tagRepository = Mockery::mock(TagRepositoryInterface::class);
        $tagRepository
            ->shouldReceive('get')
            ->withArgs([1])
            ->andReturn($tagOne)
        ;
        $tagRepository
            ->shouldReceive('get')
            ->withArgs([2])
            ->andReturn($tagTwo)
        ;

        $usecase = new EditHentaiTitle(
            fansubRepository: $fansubRepository,
            tagRepository: $tagRepository,
            hentaiTitleRepository: $hentaiTitleRepository,
            videoFileRepository: $videoFileRepository,
        );

        $hentaiTitleGot = $usecase->execute($dtoEditHentaiTitle);

        self::assertEquals($dtoEditHentaiTitle->id, $hentaiTitleGot->getId());
        self::assertEquals($dtoEditHentaiTitle->name, $hentaiTitleGot->getName());
        self::assertEquals($dtoEditHentaiTitle->alternativeNames, $hentaiTitleGot->getAlternativeNames());
        self::assertEquals($dtoEditHentaiTitle->type, $hentaiTitleGot->getType());
        self::assertEquals($dtoEditHentaiTitle->language, $hentaiTitleGot->getLanguage());
        self::assertEquals($dtoEditHentaiTitle->episodes, $hentaiTitleGot->getEpisodes());
        self::assertEquals($dtoEditHentaiTitle->statusDownload, $hentaiTitleGot->getStatusDownload());
        self::assertEquals($dtoEditHentaiTitle->statusView, $hentaiTitleGot->getStatusView());
        self::assertCount(2, $hentaiTitleGot->getFansubs());
        self::assertCount(0, $hentaiTitleGot->getVideoFiles());
        self::assertCount(2, $hentaiTitleGot->getTags());
    }

    public function testEditHentaiTitleWithHentaiTitleNotFoundException(): void
    {
        $this->expectException(HentaiTitleNotFoundException::class);

        $dtoEditHentaiTitle = new DtoEditHentaiTitle(
            id: 10,
            name: 'Super Foo',
            alternativeNames: [],
            type: HentaiTitle::TYPE_2D,
            language: HentaiTitle::LANGUAGE_PT_BR,
            episodes: 2,
            statusDownload: HentaiTitle::STATUS_DOWNLOAD_COMPLETE,
            statusView: HentaiTitle::STATUS_VIEW_DONE,
            fansubs: [1, 4],
            tags: [2, 3],
            videoFiles: [],
        );

        $hentaiTitleRepository = Mockery::mock(HentaiTitleRepositoryInterface::class);
        $hentaiTitleRepository
            ->shouldReceive('get')
            ->withArgs([$dtoEditHentaiTitle->id])
            ->andReturn(null)
            ->once()
        ;

        $videoFileRepository = Mockery::mock(VideoFileRepositoryInterface::class);
        $fansubRepository = Mockery::mock(FansubRepositoryInterface::class);
        $tagRepository = Mockery::mock(TagRepositoryInterface::class);

        $usecase = new EditHentaiTitle(
            fansubRepository: $fansubRepository,
            tagRepository: $tagRepository,
            hentaiTitleRepository: $hentaiTitleRepository,
            videoFileRepository: $videoFileRepository,
        );

        $usecase->execute($dtoEditHentaiTitle);
    }

    public function testEditHentaiTitleWithFansubsNotFoundException(): void
    {
        $this->expectException(FansubsNotFoundException::class);

        $dtoEditHentaiTitle = new DtoEditHentaiTitle(
            id: 10,
            name: 'Super Foo',
            alternativeNames: [],
            type: HentaiTitle::TYPE_2D,
            language: HentaiTitle::LANGUAGE_PT_BR,
            episodes: 2,
            statusDownload: HentaiTitle::STATUS_DOWNLOAD_COMPLETE,
            statusView: HentaiTitle::STATUS_VIEW_DONE,
            fansubs: [1, 2],
            tags: [1, 2],
            videoFiles: [],
        );

        $fansubOne = (new Fansub())->setId(1)->setName('One Fansub');
        $fansubTwo = (new Fansub())->setId(2)->setName('Two Fansub');

        $tagOne = (new Tag())->setId(1)->setType(Tag::TYPE_ALL)->setName('one');
        $tagTwo = (new Tag())->setId(2)->setType(Tag::TYPE_ALL)->setName('two');

        $hentaiTitle = (new HentaiTitle())
            ->setId($dtoEditHentaiTitle->id)
            ->setName('Title Foo')
            ->setAlternativeNames(['ほげ'])
            ->setType(HentaiTitle::TYPE_2D)
            ->setLanguage(HentaiTitle::LANGUAGE_PT_BR)
            ->setEpisodes(2)
            ->setStatusDownload(HentaiTitle::STATUS_DOWNLOAD_COMPLETE)
            ->setStatusView(HentaiTitle::STATUS_VIEW_DONE)
            ->addFansub($fansubOne)
            ->addFansub($fansubTwo)
            ->addTag($tagOne)
            ->addTag($tagTwo)
            ->setCreatedAt(new DateTimeImmutable('2023-06-29 19:18:17'))
        ;

        $hentaiTitleRepository = Mockery::mock(HentaiTitleRepositoryInterface::class);
        $hentaiTitleRepository
            ->shouldReceive('get')
            ->withArgs([$dtoEditHentaiTitle->id])
            ->andReturn($hentaiTitle)
            ->once()
        ;

        $videoFileRepository = Mockery::mock(VideoFileRepositoryInterface::class);

        $fansubRepository = Mockery::mock(FansubRepositoryInterface::class);
        $fansubRepository
            ->shouldReceive('get')
            ->withArgs([1])
            ->andReturn($fansubOne)
        ;
        $fansubRepository
            ->shouldReceive('get')
            ->withArgs([2])
            ->andReturn(null)
        ;

        $tagRepository = Mockery::mock(TagRepositoryInterface::class);

        $usecase = new EditHentaiTitle(
            fansubRepository: $fansubRepository,
            tagRepository: $tagRepository,
            hentaiTitleRepository: $hentaiTitleRepository,
            videoFileRepository: $videoFileRepository,
        );

        $usecase->execute($dtoEditHentaiTitle);
    }


    public function testEditHentaiTitleWithTagsNotFoundException(): void
    {
        $this->expectException(TagsNotFoundException::class);

        $dtoEditHentaiTitle = new DtoEditHentaiTitle(
            id: 10,
            name: 'Super Foo',
            alternativeNames: [],
            type: HentaiTitle::TYPE_2D,
            language: HentaiTitle::LANGUAGE_PT_BR,
            episodes: 2,
            statusDownload: HentaiTitle::STATUS_DOWNLOAD_COMPLETE,
            statusView: HentaiTitle::STATUS_VIEW_DONE,
            fansubs: [1, 2],
            tags: [1, 2],
            videoFiles: [],
        );

        $fansubOne = (new Fansub())->setId(1)->setName('One Fansub');
        $fansubTwo = (new Fansub())->setId(2)->setName('Two Fansub');

        $tagOne = (new Tag())->setId(1)->setType(Tag::TYPE_ALL)->setName('one');
        $tagTwo = (new Tag())->setId(2)->setType(Tag::TYPE_ALL)->setName('two');

        $hentaiTitle = (new HentaiTitle())
            ->setId($dtoEditHentaiTitle->id)
            ->setName('Title Foo')
            ->setAlternativeNames(['ほげ'])
            ->setType(HentaiTitle::TYPE_2D)
            ->setLanguage(HentaiTitle::LANGUAGE_PT_BR)
            ->setEpisodes(2)
            ->setStatusDownload(HentaiTitle::STATUS_DOWNLOAD_COMPLETE)
            ->setStatusView(HentaiTitle::STATUS_VIEW_DONE)
            ->addFansub($fansubOne)
            ->addFansub($fansubTwo)
            ->addTag($tagOne)
            ->addTag($tagTwo)
            ->setCreatedAt(new DateTimeImmutable('2023-06-29 19:18:17'))
        ;

        $hentaiTitleRepository = Mockery::mock(HentaiTitleRepositoryInterface::class);
        $hentaiTitleRepository
            ->shouldReceive('get')
            ->withArgs([$dtoEditHentaiTitle->id])
            ->andReturn($hentaiTitle)
            ->once()
        ;

        $videoFileRepository = Mockery::mock(VideoFileRepositoryInterface::class);

        $fansubRepository = Mockery::mock(FansubRepositoryInterface::class);
        $fansubRepository
            ->shouldReceive('get')
            ->withArgs([1])
            ->andReturn($fansubOne)
        ;
        $fansubRepository
            ->shouldReceive('get')
            ->withArgs([2])
            ->andReturn($fansubTwo)
        ;

        $tagRepository = Mockery::mock(TagRepositoryInterface::class);
        $tagRepository
            ->shouldReceive('get')
            ->withArgs([1])
            ->andReturn(null)
        ;
        $tagRepository
            ->shouldReceive('get')
            ->withArgs([2])
            ->andReturn($tagTwo)
        ;

        $usecase = new EditHentaiTitle(
            fansubRepository: $fansubRepository,
            tagRepository: $tagRepository,
            hentaiTitleRepository: $hentaiTitleRepository,
            videoFileRepository: $videoFileRepository,
        );

        $usecase->execute($dtoEditHentaiTitle);
    }
}
