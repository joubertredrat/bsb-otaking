<?php

declare(strict_types=1);

namespace App\UseCase;

use App\Dto\EditHentaiTitle as DtoEditHentaiTitle;
use App\Entity\HentaiTitle;
use App\Exception\UseCase\EditHentaiTitle\HentaiTitleNotFoundException;
use App\Repository\HentaiTitleRepositoryInterface;

class EditHentaiTitle
{
    public function __construct(
        protected HentaiTitleRepositoryInterface $hentaiTitleRepository,
    ) {
    }

    public function execute(DtoEditHentaiTitle $editHentaiTitle): HentaiTitle
    {
        $hentaiTitle = $this->hentaiTitleRepository->get($editHentaiTitle->id);
        if (!$hentaiTitle instanceof HentaiTitle) {
            throw HentaiTitleNotFoundException::create($editHentaiTitle->id);
        }

        $hentaiTitle->setName($editHentaiTitle->name);
        $hentaiTitle->setAlternativeNames($editHentaiTitle->alternativeNames);
        $hentaiTitle->setType($editHentaiTitle->type);
        $hentaiTitle->setLanguage($editHentaiTitle->language);
        $hentaiTitle->setEpisodes($editHentaiTitle->episodes);
        $hentaiTitle->setStatusDownload($editHentaiTitle->statusDownload);
        $hentaiTitle->setStatusView($editHentaiTitle->statusView);

        $this->hentaiTitleRepository->save($hentaiTitle, true);

        return $hentaiTitle;
    }
}
