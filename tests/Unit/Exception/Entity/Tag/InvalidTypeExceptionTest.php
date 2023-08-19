<?php

declare(strict_types=1);

namespace App\Tests\Unit\Exception\Entity\Tag;

use App\Exception\Entity\Tag\InvalidTypeException;
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
