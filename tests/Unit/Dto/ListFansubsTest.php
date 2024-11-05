<?php

declare(strict_types=1);

namespace App\Tests\Unit\Dto;

use App\Dto\ListFansubs;
use App\Dto\Pagination;
use PHPUnit\Framework\TestCase;

class ListFansubsTest extends TestCase
{
    public function testListFansubs(): void
    {
        $paginationExpected = new Pagination(page: 1, itemsPerPage: 10);
        $fansubNameExpected = 'foo';

        $listFansubs = new ListFansubs(
            pagination: $paginationExpected,
            fansubName: $fansubNameExpected,
        );

        self::assertEquals($paginationExpected, $listFansubs->pagination);
        self::assertEquals($fansubNameExpected, $listFansubs->fansubName);
    }
}
