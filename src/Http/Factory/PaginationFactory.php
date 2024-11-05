<?php

declare(strict_types=1);

namespace App\Http\Factory;

use App\Dto\Pagination;
use Symfony\Component\HttpFoundation\Request;

class PaginationFactory
{
    public const REQUEST_QUERY_STRING_PAGE = 'page';
    public const REQUEST_QUERY_STRING_ITEMS_PER_PAGE = 'itemsPerPage';

    public static function createFromRequest(Request $request): Pagination
    {
        $page = $request
            ->query
            ->getInt(self::REQUEST_QUERY_STRING_PAGE, Pagination::DEFAULT_PAGE)
        ;
        $itemsPerPage = $request
            ->query
            ->getInt(self::REQUEST_QUERY_STRING_ITEMS_PER_PAGE, Pagination::DEFAULT_ITEMS_PER_PAGE)
        ;

        return Pagination::create($page, $itemsPerPage);
    }
}
