<?php

declare(strict_types=1);

namespace App\Tests\Unit\ValueObject;

use App\ValueObject\PaginatedItems;
use App\ValueObject\Total;
use PHPUnit\Framework\TestCase;

class PaginatedItemsTest extends TestCase
{
    public function testAttributes(): void
    {
        $itemsExpected = ['foo', 'bar'];
        $totalExpected = new Total(2);
        $paginatedItems = new PaginatedItems($itemsExpected, $totalExpected);

        self::assertEquals($itemsExpected, $paginatedItems->items);
        self::assertEquals($totalExpected, $paginatedItems->total);
    }
}
