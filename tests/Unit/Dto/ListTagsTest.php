<?php

declare(strict_types=1);

namespace App\Tests\Unit\Dto;

use App\Dto\ListTags;
use App\Dto\Pagination;
use PHPUnit\Framework\TestCase;

class ListTagsTest extends TestCase
{
    public function testListTags(): void
    {
        $paginationExpected = new Pagination(page: 1, itemsPerPage: 10);
        $resourceNameExpected = 'foo';

        $listTags = new ListTags(
            pagination: $paginationExpected,
            resourceName: $resourceNameExpected,
        );

        self::assertEquals($paginationExpected, $listTags->pagination);
        self::assertEquals($resourceNameExpected, $listTags->resourceName);
    }
}
