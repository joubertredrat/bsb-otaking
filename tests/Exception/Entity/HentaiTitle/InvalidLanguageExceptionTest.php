<?php

declare(strict_types=1);

namespace App\Tests\Exception\Entity\HentaiTitle;

use App\Exception\Entity\HentaiTitle\InvalidLanguageException;
use PHPUnit\Framework\TestCase;

class InvalidLanguageExceptionTest extends TestCase
{
    public function testThrowException(): void
    {
        $this->expectException(InvalidLanguageException::class);
        $this->expectExceptionMessage('Invalid language got [ foo ], languages available [ bar, baz ]');

        throw InvalidLanguageException::create('foo', ['bar', 'baz']);
    }
}
