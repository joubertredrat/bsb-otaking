<?php

declare(strict_types=1);

namespace App\Tests\Unit\Exception\Dto\EditHentaiTitle;

use App\Exception\Dto\EditHentaiTitle\InvalidArgumentsException;
use PHPUnit\Framework\TestCase;

class InvalidArgumentsExceptionTest extends TestCase
{
    public function testThrowException(): void
    {
        $this->expectException(InvalidArgumentsException::class);
        $this->expectExceptionMessage('Invalid arguments got: foo, bar');

        throw InvalidArgumentsException::create(['foo', 'bar']);
    }
}
