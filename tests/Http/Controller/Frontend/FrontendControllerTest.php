<?php

declare(strict_types=1);

namespace App\Tests\Http\Controller\Frontend;

use App\Http\Controller\Frontend\FrontendController;
use App\Tests\Http\Controller\ControllerTestCase;

class FrontendControllerTest extends ControllerTestCase
{
    public function testPageIndex(): void
    {
        $container = $this->getContainerMock();
        $controller = new FrontendController();
        $controller->setContainer($container);

        $response = $controller->pageIndex();
        self::assertEqualStatusOk($response->getStatusCode());
    }

    public function testPageFansub(): void
    {
        $container = $this->getContainerMock();
        $controller = new FrontendController();
        $controller->setContainer($container);

        $response = $controller->pageFansub();
        self::assertEqualStatusOk($response->getStatusCode());
    }

    public function testPageTag(): void
    {
        $container = $this->getContainerMock();
        $controller = new FrontendController();
        $controller->setContainer($container);

        $response = $controller->pageTag();
        self::assertEqualStatusOk($response->getStatusCode());
    }

    public function testPageHentaiTitle(): void
    {
        $container = $this->getContainerMock();
        $controller = new FrontendController();
        $controller->setContainer($container);

        $response = $controller->pageHentaiTitle();
        self::assertEqualStatusOk($response->getStatusCode());
    }
}
