<?php

declare(strict_types=1);

namespace App\Tests\EventListener;

use App\EventListener\ExceptionListener;
use App\Exception\Http\Request\AbstractJsonRequest\InvalidJsonRequestException;
use App\Exception\UseCase\CreateFansub\FansubNameAlreadyExistsException;
use App\Exception\UseCase\CreateHentaiTitle\FansubsNotFoundException;
use App\Exception\UseCase\CreateHentaiTitle\TagsNotFoundException;
use App\Exception\UseCase\CreateTag\TagAlreadyExistsException;
use App\Exception\UseCase\GetHentaiTitle\HentaiTitleNotFoundException;
use Exception;
use Mockery;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Throwable;

class ExceptionListenerTest extends TestCase
{
    public function testOnKernelExceptionWithInvalidJsonRequestException(): void
    {
        $dispatcher = $this->getEventDispatcherMock();
        $event = $this->getExceptionEvent(InvalidJsonRequestException::create(['foo' => 'bar']));
        $dispatcher->dispatch($event, 'onKernelException');
        $this->assertInstanceOf(JsonResponse::class, $event->getResponse());
    }

    public function testOnKernelExceptionWithFansubNameAlreadyExistsException(): void
    {
        $dispatcher = $this->getEventDispatcherMock();
        $event = $this->getExceptionEvent(FansubNameAlreadyExistsException::create('foo'));
        $dispatcher->dispatch($event, 'onKernelException');
        $this->assertInstanceOf(JsonResponse::class, $event->getResponse());
    }

    public function testOnKernelExceptionWithTagAlreadyExistsException(): void
    {
        $dispatcher = $this->getEventDispatcherMock();
        $event = $this->getExceptionEvent(TagAlreadyExistsException::create('foo', 'bar'));
        $dispatcher->dispatch($event, 'onKernelException');
        $this->assertInstanceOf(JsonResponse::class, $event->getResponse());
    }

    public function testOnKernelExceptionWithFansubsNotFoundException(): void
    {
        $dispatcher = $this->getEventDispatcherMock();
        $event = $this->getExceptionEvent(FansubsNotFoundException::create([1, 2, 3]));
        $dispatcher->dispatch($event, 'onKernelException');
        $this->assertInstanceOf(JsonResponse::class, $event->getResponse());
    }

    public function testOnKernelExceptionWithTagsNotFoundException(): void
    {
        $dispatcher = $this->getEventDispatcherMock();
        $event = $this->getExceptionEvent(TagsNotFoundException::create([1, 2, 3]));
        $dispatcher->dispatch($event, 'onKernelException');
        $this->assertInstanceOf(JsonResponse::class, $event->getResponse());
    }

    public function testOnKernelExceptionWithHentaiTitleNotFoundException(): void
    {
        $dispatcher = $this->getEventDispatcherMock();
        $event = $this->getExceptionEvent(HentaiTitleNotFoundException::create(10));
        $dispatcher->dispatch($event, 'onKernelException');
        $this->assertInstanceOf(JsonResponse::class, $event->getResponse());
    }

    public function testOnKernelExceptionWithNotFoundHttpException(): void
    {
        $dispatcher = $this->getEventDispatcherMock();
        $event = $this->getExceptionEvent(new NotFoundHttpException('No route found for GET: /'));
        $dispatcher->dispatch($event, 'onKernelException');
        $this->assertInstanceOf(JsonResponse::class, $event->getResponse());
    }

    public function testOnKernelExceptionWithUnknownException(): void
    {
        $dispatcher = $this->getEventDispatcherMock();
        $event = $this->getExceptionEvent(new Exception('foo'));
        $dispatcher->dispatch($event, 'onKernelException');
        $this->assertInstanceOf(JsonResponse::class, $event->getResponse());
    }

    private function getExceptionEvent(Throwable $e): ExceptionEvent
    {
        return new ExceptionEvent(
            kernel: $this->getHttpKernelMock(),
            request: $this->getRequestMock(),
            requestType: HttpKernelInterface::MAIN_REQUEST,
            e: $e,
        );
    }

    private function getEventDispatcherMock(): EventDispatcher
    {
        $dispatcher = new EventDispatcher();
        $listener = new ExceptionListener();
        $dispatcher->addListener('onKernelException', [$listener, 'onKernelException']);
        return $dispatcher;
    }

    private function getHttpKernelMock(): HttpKernelInterface
    {
        return Mockery::mock(HttpKernelInterface::class);
    }

    private function getRequestMock(): Request
    {
        return Request::createFromGlobals();
    }
}
