<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Exception\Http\Request\AbstractJsonRequest\InvalidJsonRequestException;
use App\Exception\UseCase\CreateFansub\FansubNameAlreadyExistsException;
use App\Exception\UseCase\CreateHentaiTitle\FansubsNotFoundException;
use App\Exception\UseCase\CreateHentaiTitle\TagsNotFoundException;
use App\Exception\UseCase\CreateTag\TagAlreadyExistsException;
use App\Exception\UseCase\GetHentaiTitle\HentaiTitleNotFoundException;
use Fig\Http\Message\StatusCodeInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        if ($exception instanceof InvalidJsonRequestException) {
            $event->setResponse($this->getJsonResponseBadRequest($exception->getErrors()));
            return;
        }

        if ($exception instanceof FansubNameAlreadyExistsException) {
            $event->setResponse($this->getJsonResponseUnprocessableEntity($exception));
            return;
        }

        if ($exception instanceof TagAlreadyExistsException) {
            $event->setResponse($this->getJsonResponseUnprocessableEntity($exception));
            return;
        }

        if ($exception instanceof FansubsNotFoundException) {
            $event->setResponse($this->getJsonResponseUnprocessableEntity($exception));
            return;
        }

        if ($exception instanceof TagsNotFoundException) {
            $event->setResponse($this->getJsonResponseUnprocessableEntity($exception));
            return;
        }

        if ($exception instanceof HentaiTitleNotFoundException) {
            $event->setResponse($this->getJsonResponseNotFound($exception));
            return;
        }

        if ($exception instanceof NotFoundHttpException) {
            $event->setResponse($this->getJsonResponseNotFound($exception));
            return;
        }

        if ($exception instanceof Throwable) {
            $event->setResponse($this->getJsonResponseInternalServerError($exception));
        }
    }

    private function getJsonResponseBadRequest(Throwable | array $error): JsonResponse
    {
        return new JsonResponse(
            data: $this->getErrors($error),
            status: StatusCodeInterface::STATUS_BAD_REQUEST,
        );
    }

    private function getJsonResponseNotFound(Throwable | array $error): JsonResponse
    {
        return new JsonResponse(
            data: $this->getErrors($error),
            status: StatusCodeInterface::STATUS_NOT_FOUND,
        );
    }

    private function getJsonResponseUnprocessableEntity(Throwable | array $error): JsonResponse
    {
        return new JsonResponse(
            data: $this->getErrors($error),
            status: StatusCodeInterface::STATUS_UNPROCESSABLE_ENTITY,
        );
    }

    private function getJsonResponseInternalServerError(Throwable | array $error): JsonResponse
    {
        return new JsonResponse(
            data: $this->getErrors($error),
            status: StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR,
        );
    }

    private function getErrors(Throwable | array $error): array
    {
        return ['errors' => $error instanceof Throwable ? [$error->getMessage()] : $error];
    }
}
