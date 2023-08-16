<?php

declare(strict_types=1);

namespace App\Tests\Exception\Dto\Pagination;

use App\Exception\Dto\Pagination\InvalidItemsPerPageException;
use PHPUnit\Framework\TestCase;

class InvalidItemsPerPageExceptionTest extends TestCase
{
    public function testThrowException(): void
    {
        $this->expectException(InvalidItemsPerPageException::class);
        $this->expectExceptionMessage('Invalid items per page got: 10');

        throw InvalidItemsPerPageException::create(10);
    }
}
