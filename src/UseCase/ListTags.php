<?php

declare(strict_types=1);

namespace App\UseCase;

use App\Dto\ListTags as DtoListTags;
use App\Repository\PaginationSQL;
use App\Repository\TagRepositoryInterface;
use App\ValueObject\PaginatedItems;
use App\ValueObject\Total;

class ListTags
{
    public function __construct(
        protected TagRepositoryInterface $tagRepository,
    ) {
    }

    public function execute(DtoListTags $listTags): PaginatedItems
    {
        $data = $this
            ->tagRepository
            ->list(new PaginationSQL($listTags->pagination), $listTags->resourceName)
        ;
        $total = $this
            ->tagRepository
            ->countAll($listTags->resourceName)
        ;

        return new PaginatedItems($data, new Total($total));
    }
}
