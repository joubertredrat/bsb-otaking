<?php

declare(strict_types=1);

namespace App\Dto;

use App\Exception\Dto\Pagination\InvalidItemsPerPageException;
use App\Exception\Dto\Pagination\InvalidPageException;

class Pagination
{
    public const DEFAULT_PAGE = 1;
    public const DEFAULT_ITEMS_PER_PAGE = 10;

    public function __construct(
        public readonly int $page,
        public readonly int $itemsPerPage,
    ) {
        if (!self::isValidPage($page)) {
            throw InvalidPageException::create($page);
        }
        if (!self::isValidItemsPerPage($itemsPerPage)) {
            throw InvalidItemsPerPageException::create($itemsPerPage);
        }
    }

    public static function isValidPage(int $page): bool
    {
        return $page > 0;
    }

    public static function isValidItemsPerPage(int $itemsPerPage): bool
    {
        return $itemsPerPage > 0;
    }

    public static function create(?int $page = null, ?int $itemsPerPage = null): self
    {
        $page ??= self::DEFAULT_PAGE;
        $itemsPerPage ??= self::DEFAULT_ITEMS_PER_PAGE;
        return new self(page: $page, itemsPerPage: $itemsPerPage);
    }
}
