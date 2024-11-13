<?php

declare(strict_types=1);

namespace App\UseCase;

use App\Dto\ListHentaiTitles as DtoListHentaiTitles;
use App\Repository\HentaiTitleRepositoryInterface;
use App\Repository\PaginationSQL;
use App\ValueObject\PaginatedItems;
use App\ValueObject\Total;

class ListHentaiTitles
{
    public function __construct(
        protected HentaiTitleRepositoryInterface $hentaiTitleRepository,
    ) {
    }

    public function execute(DtoListHentaiTitles $listHentaiTitles): PaginatedItems
    {
        $data = $this
            ->hentaiTitleRepository
            ->list(
                new PaginationSQL($listHentaiTitles->pagination),
                $listHentaiTitles->searchCriteria,
                $listHentaiTitles->type,
                $listHentaiTitles->language,
                $listHentaiTitles->rating,
                $listHentaiTitles->statusDownload,
                $listHentaiTitles->statusView,
                $listHentaiTitles->fansubId,
                $listHentaiTitles->tagId,
            )
        ;
        $total = $this
            ->hentaiTitleRepository
            ->countAll(
                $listHentaiTitles->searchCriteria,
                $listHentaiTitles->type,
                $listHentaiTitles->language,
                $listHentaiTitles->rating,
                $listHentaiTitles->statusDownload,
                $listHentaiTitles->statusView,
                $listHentaiTitles->fansubId,
                $listHentaiTitles->tagId,
            )
        ;

        return new PaginatedItems($data, new Total($total));
    }
}
