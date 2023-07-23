<?php

declare(strict_types=1);

namespace App\Tests\Exception\Entity\HentaiTitle;

use App\Exception\Entity\HentaiTitle\InvalidStatusViewException;
use PHPUnit\Framework\TestCase;

class InvalidStatusViewExceptionTest extends TestCase
{
    public function testThrowException(): void
    {
        $this->expectException(InvalidStatusViewException::class);
        $this->expectExceptionMessage('Invalid status view got [ foo ], statuses view available [ bar, baz ]');

        throw InvalidStatusViewException::create('foo', ['bar', 'baz']);
    }
}
