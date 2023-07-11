<?php

declare(strict_types=1);

namespace App\Tests\Exception\Http\Request\AbstractJsonRequest;

use App\Exception\Http\Request\AbstractJsonRequest\InvalidJsonRequest;
use PHPUnit\Framework\TestCase;

class InvalidJsonRequestTest extends TestCase
{
    public function testThrowException(): void
    {
        $this->expectException(InvalidJsonRequest::class);
        $this->expectExceptionMessage('');

        $errorsExpected = [
            [
                'property' => 'name',
                'value' => 'Foo',
                'message' => 'Invalid format',
            ],
        ];

        $exception = InvalidJsonRequest::dispatch($errorsExpected);
        self::assertEquals($errorsExpected, $exception->getErrors());

        throw $exception;
    }
}
