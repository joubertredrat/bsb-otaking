<?php

declare(strict_types=1);

namespace App\Tests\Unit\Dto;

use App\Dto\Pagination;
use App\Exception\Dto\Pagination\InvalidItemsPerPageException;
use App\Exception\Dto\Pagination\InvalidPageException;
use PHPUnit\Framework\TestCase;

class PaginationTest extends TestCase
{
    public function testPagination(): void
    {
        $pageExpected = 2;
        $itemsPerPageExpected = 50;

        $pagination = new Pagination(
            page: $pageExpected,
            itemsPerPage: $itemsPerPageExpected,
        );

        self::assertEquals($pageExpected, $pagination->page);
        self::assertEquals($itemsPerPageExpected, $pagination->itemsPerPage);
    }

    public function testPaginationWithInvalidPage(): void
    {
        $this->expectException(InvalidPageException::class);

        new Pagination(
            page: 0,
            itemsPerPage: 50,
        );
    }

    public function testPaginationWithInvalidItemsPerPage(): void
    {
        $this->expectException(InvalidItemsPerPageException::class);

        new Pagination(
            page: 2,
            itemsPerPage: 0,
        );
    }

    public function testCreatePaginationWithDefaultValues(): void
    {
        $pagination = Pagination::create();

        self::assertEquals(Pagination::DEFAULT_PAGE, $pagination->page);
        self::assertEquals(Pagination::DEFAULT_ITEMS_PER_PAGE, $pagination->itemsPerPage);
    }

    public function testCreatePaginationWithDefinedValues(): void
    {
        $pageExpected = 2;
        $itemsPerPageExpected = 50;

        $pagination = Pagination::create($pageExpected, $itemsPerPageExpected);

        self::assertEquals($pageExpected, $pagination->page);
        self::assertEquals($itemsPerPageExpected, $pagination->itemsPerPage);
    }
}
