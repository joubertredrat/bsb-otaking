<?php

declare(strict_types=1);

namespace App\Tests\Exception\Entity\PrimaryKey;

use App\Exception\Entity\PrimaryKey\InvalidPrimaryKeyException;
use PHPUnit\Framework\TestCase;

class InvalidPrimaryKeyExceptionTest extends TestCase
{
    public function testThrowException(): void
    {
        $this->expectException(InvalidPrimaryKeyException::class);
        $this->expectExceptionMessage('Invalid primary key got [ 2 ]');

        throw InvalidPrimaryKeyException::create(2);
    }
}
