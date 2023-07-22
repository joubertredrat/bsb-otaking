<?php

declare(strict_types=1);

namespace App\Tests\EventListener;

use App\EventListener\ExceptionListener;
use App\Exception\Http\Request\AbstractJsonRequest\InvalidJsonRequestException;
use Mockery;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class ExceptionListenerTest extends TestCase
{
    public function testOnKernelExceptionWithInvalidJsonRequestException(): void
    {
        $dispatcher = new EventDispatcher();
        $listener = new ExceptionListener();
        $dispatcher->addListener('onKernelException', [$listener, 'onKernelException']);

        $kernel = Mockery::mock(HttpKernelInterface::class);
        $request = Request::createFromGlobals();
        $event = new ExceptionEvent(
            kernel: $kernel,
            request: $request,
            requestType: HttpKernelInterface::MAIN_REQUEST,
            e: InvalidJsonRequestException::create(['foo' => 'bar']),
        );

        $dispatcher->dispatch($event, 'onKernelException');
        $this->assertInstanceOf(JsonResponse::class, $event->getResponse());
    }
}
