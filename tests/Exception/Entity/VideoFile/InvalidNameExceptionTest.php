<?php

declare(strict_types=1);

namespace App\Tests\Exception\Entity\VideoFile;

use App\Exception\Entity\VideoFile\InvalidNameException;
use PHPUnit\Framework\TestCase;

class InvalidNameExceptionTest extends TestCase
{
    public function testThrowException(): void
    {
        $this->expectException(InvalidNameException::class);
        $this->expectExceptionMessage('Invalid name got [ foo ]');

        throw InvalidNameException::create('foo');
    }
}
