<?php

declare(strict_types=1);

namespace App\Tests\Unit\Exception\Dto\Pagination;

use App\Exception\Dto\Pagination\InvalidPageException;
use PHPUnit\Framework\TestCase;

class InvalidPageExceptionTest extends TestCase
{
    public function testThrowException(): void
    {
        $this->expectException(InvalidPageException::class);
        $this->expectExceptionMessage('Invalid page got: 10');

        throw InvalidPageException::create(10);
    }
}
