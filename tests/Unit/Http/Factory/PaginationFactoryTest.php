<?php

declare(strict_types=1);

namespace App\Tests\Unit\Http\Factory;

use App\Dto\Pagination;
use App\Http\Factory\PaginationFactory;
use App\Tests\Helper;
use PHPUnit\Framework\TestCase;

class PaginationFactoryTest extends TestCase
{
    public static function testCreateFromRequestWithDefaultValues(): void
    {
        $request = Helper::getRequestMock();
        $pagination = PaginationFactory::createFromRequest($request);

        self::assertEquals(Pagination::DEFAULT_PAGE, $pagination->page);
        self::assertEquals(Pagination::DEFAULT_ITEMS_PER_PAGE, $pagination->itemsPerPage);
    }

    public static function testCreateFromRequestWithDefinedValues(): void
    {
        $pageExpected = 5;
        $itemsPerPageExpected = 100;

        $request = Helper::getRequestMock(queryData: [
            'page' => $pageExpected,
            'itemsPerPage' => $itemsPerPageExpected,
        ]);
        $pagination = PaginationFactory::createFromRequest($request);

        self::assertEquals($pageExpected, $pagination->page);
        self::assertEquals($itemsPerPageExpected, $pagination->itemsPerPage);
    }
}
