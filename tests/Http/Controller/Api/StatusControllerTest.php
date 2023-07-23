<?php

declare(strict_types=1);

namespace App\Tests\Http\Controller\Api;

use App\Http\Controller\Api\StatusController;

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
