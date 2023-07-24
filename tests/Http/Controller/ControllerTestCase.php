<?php

declare(strict_types=1);

namespace App\Tests\Http\Controller;

use Fig\Http\Message\StatusCodeInterface;
use Mockery;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Twig\Environment;

abstract class ControllerTestCase extends TestCase
{
    public function getContainerMock(): ContainerInterface
    {
        $container = Mockery::mock(ContainerInterface::class);
        $container
            ->shouldReceive('has')
            ->withArgs(['serializer'])
            ->andReturn(false)
        ;
        $container
            ->shouldReceive('has')
            ->withArgs(['twig'])
            ->andReturn(true)
        ;

        $environment = Mockery::mock(Environment::class);
        $environment
            ->shouldReceive('render')
            ->andReturn('<html></html>')
        ;

        $container
            ->shouldReceive('get')
            ->withArgs(['twig'])
            ->andReturn($environment)
        ;

        return $container;
    }

    public static function assertEqualStatusOk(mixed $actual): void
    {
        self::assertEquals(StatusCodeInterface::STATUS_OK, $actual);
    }

    public static function assertEqualStatusCreated(mixed $actual): void
    {
        self::assertEquals(StatusCodeInterface::STATUS_CREATED, $actual);
    }
}
