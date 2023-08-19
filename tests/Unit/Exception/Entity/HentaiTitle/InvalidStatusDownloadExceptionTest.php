<?php

declare(strict_types=1);

namespace App\Tests\Unit\Exception\Entity\HentaiTitle;

use App\Exception\Entity\HentaiTitle\InvalidStatusDownloadException;
use PHPUnit\Framework\TestCase;

class InvalidStatusDownloadExceptionTest extends TestCase
{
    public function testThrowException(): void
    {
        $this->expectException(InvalidStatusDownloadException::class);
        $this->expectExceptionMessage('Invalid status download got [ foo ], statuses download available [ bar, baz ]');

        throw InvalidStatusDownloadException::create('foo', ['bar', 'baz']);
    }
}
