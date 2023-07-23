<?php

declare(strict_types=1);

namespace App\Tests\Http\Controller\Api;

use App\Http\Controller\Api\StatusController;
use App\Tests\Http\Controller\ControllerTestCase;

class StatusControllerTest extends ControllerTestCase
{
    public function testGet(): void
    {
        $container = $this->getContainerMock();

        $controller = new StatusController();
        $controller->setContainer($container);
        $response = $controller->get();

        self::assertEqualStatusOk($response->getStatusCode());
    }
}
