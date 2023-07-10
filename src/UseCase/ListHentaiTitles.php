<?php

declare(strict_types=1);

namespace App\UseCase;

use App\Repository\HentaiTitleRepositoryInterface;

class ListHentaiTitles
{
    public function __construct(
        protected HentaiTitleRepositoryInterface $hentaiTitleRepository,
    ) {
    }

    public function execute(): array
    {
        return $this->hentaiTitleRepository->list();
    }
}
