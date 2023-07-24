<?php

declare(strict_types=1);

namespace App\UseCase;

use App\Entity\HentaiTitle;
use App\Exception\UseCase\GetHentaiTitle\HentaiTitleNotFoundException;
use App\Repository\HentaiTitleRepositoryInterface;

class GetHentaiTitle
{
    public function __construct(
        protected HentaiTitleRepositoryInterface $hentaiTitleRepository,
    ) {
    }

    public function execute(int $id): HentaiTitle
    {
        $hentaiTitle = $this->hentaiTitleRepository->get($id);
        if (!$hentaiTitle instanceof HentaiTitle) {
            throw HentaiTitleNotFoundException::create($id);
        }

        return $hentaiTitle;
    }
}
