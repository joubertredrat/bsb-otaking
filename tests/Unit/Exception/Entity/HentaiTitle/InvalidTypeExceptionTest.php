<?php

declare(strict_types=1);

namespace App\Tests\Unit\Exception\Entity\HentaiTitle;

use App\Exception\Entity\HentaiTitle\InvalidTypeException;
use PHPUnit\Framework\TestCase;

class InvalidTypeExceptionTest extends TestCase
{
    public function testThrowException(): void
    {
        $this->expectException(InvalidTypeException::class);
        $this->expectExceptionMessage('Invalid type got [ foo ], types available [ bar, baz ]');

        throw InvalidTypeException::create('foo', ['bar', 'baz']);
    }
}
