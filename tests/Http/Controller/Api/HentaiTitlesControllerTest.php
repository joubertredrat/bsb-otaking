<?php

declare(strict_types=1);

namespace App\Tests\Http\Controller\Api;

use App\Dto\CreateHentaiTitle as DtoCreateHentaiTitle;
use App\Entity\HentaiTitle;
use App\Http\Controller\Api\HentaiTitlesController;
use App\Http\Request\CreateHentaiTitleRequest;
use App\Tests\Helper;
use App\Tests\Http\Controller\ControllerTestCase;
use App\UseCase\CreateHentaiTitle;
use App\UseCase\GetHentaiTitle;
use App\UseCase\ListHentaiTitles;
use Mockery;

class HentaiTitlesControllerTest extends ControllerTestCase
{
    public function testList(): void
    {
        $container = $this->getContainerMock();

        $createHentaiTitle = Mockery::mock(CreateHentaiTitle::class);
        $hentaiTitleFoo = self::getHentaiTitleMock('Foo');
        $hentaiTitleBar = self::getHentaiTitleMock('Bar');
        $listHentaiTitles = Mockery::mock(ListHentaiTitles::class);
        $listHentaiTitles
            ->shouldReceive('execute')
            ->andReturn([$hentaiTitleFoo, $hentaiTitleBar])
        ;
        $getHentaiTitle = Mockery::mock(GetHentaiTitle::class);

        $controller = new HentaiTitlesController(
            createHentaiTitle: $createHentaiTitle,
            listHentaiTitles: $listHentaiTitles,
            getHentaiTitle: $getHentaiTitle,
        );
        $controller->setContainer($container);

        $response = $controller->list();
        self::assertEqualStatusOk($response->getStatusCode());
    }

    public function testTypes(): void
    {
        $controller = $this->getControllerMockEmpty();
        $response = $controller->types();
        self::assertEqualStatusOk($response->getStatusCode());
    }

    public function testLanguages(): void
    {
        $controller = $this->getControllerMockEmpty();
        $response = $controller->languages();
        self::assertEqualStatusOk($response->getStatusCode());
    }

    public function testStatusesDownload(): void
    {
        $controller = $this->getControllerMockEmpty();
        $response = $controller->statusesDownload();
        self::assertEqualStatusOk($response->getStatusCode());
    }

    public function testStatusesView(): void
    {
        $controller = $this->getControllerMockEmpty();
        $response = $controller->statusesView();
        self::assertEqualStatusOk($response->getStatusCode());
    }

    public function testCreate(): void
    {
        $container = $this->getContainerMock();

        $hentaiTitleFoo = self::getHentaiTitleMock('Foo');
        $createHentaiTitle = Mockery::mock(CreateHentaiTitle::class);
        $createHentaiTitle
            ->shouldReceive('execute')
            ->with(Mockery::on(function ($argument) {
                return $argument instanceof DtoCreateHentaiTitle;
            }))
            ->andReturn($hentaiTitleFoo)
        ;
        $listHentaiTitles = Mockery::mock(ListHentaiTitles::class);
        $getHentaiTitle = Mockery::mock(GetHentaiTitle::class);

        $controller = new HentaiTitlesController(
            createHentaiTitle: $createHentaiTitle,
            listHentaiTitles: $listHentaiTitles,
            getHentaiTitle: $getHentaiTitle,
        );
        $controller->setContainer($container);

        $validator = Helper::getValidationMock();
        $request = Helper::getRequestMock([
            'name' => 'Foo',
            'type' => HentaiTitle::TYPE_2D,
            'language' => HentaiTitle::LANGUAGE_PT_BR,
            'episodes' => 2,
            'statusDownload' => HentaiTitle::STATUS_DOWNLOAD_COMPLETE,
            'statusView' => HentaiTitle::STATUS_VIEW_DONE,
            'fansubs' => [1],
            'tags' => [1, 2],
            'videoFiles' => Helper::getVideoFiles(),
        ]);
        $requestStack = Helper::getRequestStackMock($request);
        $createHentaiTitleRequest = new CreateHentaiTitleRequest(
            validator: $validator,
            requestStack: $requestStack,
            convertCase: false,
        );

        $response = $controller->create($createHentaiTitleRequest);
        self::assertEqualStatusCreated($response->getStatusCode());
    }

    public function testGet(): void
    {
        $container = $this->getContainerMock();
        $id = 10;

        $hentaiTitleFoo = self::getHentaiTitleMock('Foo');
        $createHentaiTitle = Mockery::mock(CreateHentaiTitle::class);
        $listHentaiTitles = Mockery::mock(ListHentaiTitles::class);
        $getHentaiTitle = Mockery::mock(GetHentaiTitle::class);
        $getHentaiTitle
            ->shouldReceive('execute')
            ->withArgs([$id])
            ->andReturn($hentaiTitleFoo)
        ;

        $controller = new HentaiTitlesController(
            createHentaiTitle: $createHentaiTitle,
            listHentaiTitles: $listHentaiTitles,
            getHentaiTitle: $getHentaiTitle,
        );
        $controller->setContainer($container);

        $response = $controller->get($id);
        self::assertEqualStatusOk($response->getStatusCode());
    }

    private function getControllerMockEmpty(): HentaiTitlesController
    {
        $container = $this->getContainerMock();
        $createHentaiTitle = Mockery::mock(CreateHentaiTitle::class);
        $listHentaiTitles = Mockery::mock(ListHentaiTitles::class);
        $getHentaiTitle = Mockery::mock(GetHentaiTitle::class);

        $controller = new HentaiTitlesController(
            createHentaiTitle: $createHentaiTitle,
            listHentaiTitles: $listHentaiTitles,
            getHentaiTitle: $getHentaiTitle,
        );
        $controller->setContainer($container);
        return $controller;
    }

    private static function getHentaiTitleMock(string $name): HentaiTitle
    {
        return (new HentaiTitle())
            ->setName($name)
            ->setType(HentaiTitle::TYPE_2D)
            ->setLanguage(HentaiTitle::LANGUAGE_PT_BR)
            ->setEpisodes(rand(1, 12))
            ->setStatusDownload(HentaiTitle::STATUS_DOWNLOAD_COMPLETE)
            ->setStatusView(HentaiTitle::STATUS_VIEW_DONE)
            ->setCreatedAtNow()
        ;
    }
}
