<?php

declare(strict_types=1);

namespace App\UseCase;

use App\Dto\CreateHentaiTitle as DtoCreateHentaiTitle;
use App\Entity\Fansub;
use App\Entity\HentaiTitle;
use App\Entity\Tag;
use App\Entity\VideoFile;
use App\Exception\UseCase\CreateHentaiTitle\FansubsNotFoundException;
use App\Exception\UseCase\CreateHentaiTitle\TagsNotFoundException;
use App\Repository\FansubRepositoryInterface;
use App\Repository\HentaiTitleRepositoryInterface;
use App\Repository\TagRepositoryInterface;

class CreateHentaiTitle
{
    public function __construct(
        protected FansubRepositoryInterface $fansubRepository,
        protected TagRepositoryInterface $tagRepository,
        protected HentaiTitleRepositoryInterface $hentaiTitleRepository,
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
        $hentaiTitle->setRating($createHentaiTitle->rating);
        $hentaiTitle->setStatusDownload($createHentaiTitle->statusDownload);
        $hentaiTitle->setStatusView($createHentaiTitle->statusView);

        foreach ($createHentaiTitle->videoFiles as $filename) {
            $videoFile = (new VideoFile())->setName($filename);
            $hentaiTitle->addVideoFile($videoFile);
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
            throw FansubsNotFoundException::create($notFound);
        }
    }

    private function appendTags(HentaiTitle $hentaiTitle, array $ids): void
    {
        $notFound = [];

        foreach ($ids as $id) {
            $tag = $this->tagRepository->get($id);
            if (!$tag instanceof Tag) {
                $notFound[] = $id;
                continue;
            }
            $hentaiTitle->addTag($tag);
        }

        if ($notFound) {
            throw TagsNotFoundException::create($notFound);
        }
    }
}
