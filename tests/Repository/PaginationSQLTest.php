<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\Dto\Pagination;
use App\Repository\PaginationSQL;
use PHPUnit\Framework\TestCase;

class PaginationSQLTest extends TestCase
{
    public function testOffsetLimit(): void
    {
        $offsetExpected = 200;
        $limitExpected = 50;

        $pagination = new Pagination(page: 5, itemsPerPage: 50);
        $paginationSQL = new PaginationSQL(pagination: $pagination);

        self::assertEquals($offsetExpected, $paginationSQL->getOffset());
        self::assertEquals($limitExpected, $paginationSQL->getLimit());
    }
}
