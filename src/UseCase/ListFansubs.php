<?php

declare(strict_types=1);

namespace App\UseCase;

use App\Dto\ListFansubs as DtoListFansubs;
use App\Repository\FansubRepositoryInterface;
use App\Repository\PaginationSQL;
use App\ValueObject\PaginatedItems;
use App\ValueObject\Total;

class ListFansubs
{
    public function __construct(protected FansubRepositoryInterface $fansubRepository)
    {
    }

    public function execute(DtoListFansubs $listFansubs): PaginatedItems
    {
        $data = $this
            ->fansubRepository
            ->list(new PaginationSQL($listFansubs->pagination), $listFansubs->fansubName)
        ;
        $total = $this
            ->fansubRepository
            ->countAll($listFansubs->fansubName)
        ;

        return new PaginatedItems($data, new Total($total));
    }
}
