<?php

declare(strict_types=1);

namespace App\Exception\ValueObject\Total;

use PHPUnit\Framework\TestCase;

class InvalidTotalExceptionTest extends TestCase
{
    public function testThrowException(): void
    {
        $this->expectException(InvalidTotalException::class);
        $this->expectExceptionMessage('Invalid total [ 2 ]');

        throw InvalidTotalException::create(2);
    }
}
