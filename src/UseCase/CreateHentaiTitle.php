<?php

declare(strict_types=1);

namespace App\UseCase;

use App\Dto\CreateHentaiTitle as DtoCreateHentaiTitle;
use App\Entity\Fansub;
use App\Entity\HentaiFile;
use App\Entity\HentaiTag;
use App\Entity\HentaiTitle;
use App\Exception\UseCase\CreateHentaiTitle\FansubsNotFoundException;
use App\Exception\UseCase\CreateHentaiTitle\HentaiTagsNotFoundException;
use App\Repository\FansubRepositoryInterface;
use App\Repository\HentaiTagRepositoryInterface;
use App\Repository\HentaiTitleRepositoryInterface;

class CreateHentaiTitle
{
    public function __construct(
        protected FansubRepositoryInterface $fansubRepository,
        protected HentaiTitleRepositoryInterface $hentaiTitleRepository,
        protected HentaiTagRepositoryInterface $hentaiTagRepository,
    ) {
    }

    public function execute(DtoCreateHentaiTitle $createHentaiTitle): HentaiTitle
    {
        $hentaiTitle = new HentaiTitle();

        $this->appendFansubs($hentaiTitle, $createHentaiTitle->fansubs);
        $this->appendTags($hentaiTitle, $createHentaiTitle->tags);

        $hentaiTitle->setName($createHentaiTitle->name);
        $hentaiTitle->setAlternativeNames($createHentaiTitle->alternativeNames);
        $hentaiTitle->setType($createHentaiTitle->type);
        $hentaiTitle->setLanguage($createHentaiTitle->language);
        $hentaiTitle->setEpisodes($createHentaiTitle->episodes);
        $hentaiTitle->setStatusDownload($createHentaiTitle->statusDownload);
        $hentaiTitle->setStatusView($createHentaiTitle->statusView);

        foreach ($createHentaiTitle->files as $filename) {
            $file = new HentaiFile();
            $file->setName($filename);
            $hentaiTitle->addFile($file);
        }

        $this->hentaiTitleRepository->save($hentaiTitle, true);
        return $hentaiTitle;
    }

    private function appendFansubs(HentaiTitle $hentaiTitle, array $ids): void
    {
        $notFound = [];

        foreach ($ids as $id) {
            $fansub = $this->fansubRepository->get($id);
            if (!$fansub instanceof Fansub) {
                $notFound[] = $id;
                continue;
            }
            $hentaiTitle->addFansub($fansub);
        }

        if ($notFound) {
            throw FansubsNotFoundException::dispatch($notFound);
        }
    }

    private function appendTags(HentaiTitle $hentaiTitle, array $ids): void
    {
        $notFound = [];

        foreach ($ids as $id) {
            $hentaiTag = $this->hentaiTagRepository->get($id);
            if (!$hentaiTag instanceof HentaiTag) {
                $notFound[] = $id;
                continue;
            }
            $hentaiTitle->addTag($hentaiTag);
        }

        if ($notFound) {
            throw HentaiTagsNotFoundException::dispatch($notFound);
        }
    }
}
