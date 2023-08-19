<?php

declare(strict_types=1);

namespace App\Tests\Unit\Exception\Http\Request\AbstractJsonRequest;

use App\Exception\Http\Request\AbstractJsonRequest\InvalidJsonRequestException;
use PHPUnit\Framework\TestCase;

class InvalidJsonRequestExceptionTest extends TestCase
{
    public function testThrowException(): void
    {
        $this->expectException(InvalidJsonRequestException::class);
        $this->expectExceptionMessage('');

        $errorsExpected = [
            [
                'property' => 'name',
                'value' => 'Foo',
                'message' => 'Invalid format',
            ],
        ];

        $exception = InvalidJsonRequestException::create($errorsExpected);
        self::assertEquals($errorsExpected, $exception->getErrors());

        throw $exception;
    }
}
