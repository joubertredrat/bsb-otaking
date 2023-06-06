<?php

declare(strict_types=1);

namespace App\Tests\Exception\Dto\CreateTitle;

use App\Exception\Dto\CreateTitle\InvalidArgumentsException;
use PHPUnit\Framework\TestCase;

class InvalidArgumentsExceptionTest extends TestCase
{
    public function testThrowException(): void
    {
        $this->expectException(InvalidArgumentsException::class);
        $this->expectExceptionMessage('Invalid arguments got: foo, bar');

        throw InvalidArgumentsException::dispatch(['foo', 'bar']);
    }
}
