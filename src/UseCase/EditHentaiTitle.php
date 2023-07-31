<?php

declare(strict_types=1);

namespace App\UseCase;

use App\Dto\EditHentaiTitle as DtoEditHentaiTitle;
use App\Entity\Fansub;
use App\Entity\HentaiTitle;
use App\Entity\Tag;
use App\Entity\VideoFile;
use App\Exception\UseCase\EditHentaiTitle\FansubsNotFoundException;
use App\Exception\UseCase\EditHentaiTitle\HentaiTitleNotFoundException;
use App\Exception\UseCase\EditHentaiTitle\TagsNotFoundException;
use App\Repository\FansubRepositoryInterface;
use App\Repository\HentaiTitleRepositoryInterface;
use App\Repository\TagRepositoryInterface;
use App\Repository\VideoFileRepositoryInterface;

class EditHentaiTitle
{
    public function __construct(
        protected FansubRepositoryInterface $fansubRepository,
        protected TagRepositoryInterface $tagRepository,
        protected HentaiTitleRepositoryInterface $hentaiTitleRepository,
        protected VideoFileRepositoryInterface $videoFileRepository,
    ) {
    }

    public function execute(DtoEditHentaiTitle $editHentaiTitle): HentaiTitle
    {
        $hentaiTitle = $this->hentaiTitleRepository->get($editHentaiTitle->id);
        if (!$hentaiTitle instanceof HentaiTitle) {
            throw HentaiTitleNotFoundException::create($editHentaiTitle->id);
        }

        $this->appendFansubs($hentaiTitle, $editHentaiTitle->fansubs);
        $this->appendTags($hentaiTitle, $editHentaiTitle->tags);
        $this->appendVideoFiles($hentaiTitle, $editHentaiTitle->videoFiles);

        $hentaiTitle->setName($editHentaiTitle->name);
        $hentaiTitle->setAlternativeNames($editHentaiTitle->alternativeNames);
        $hentaiTitle->setType($editHentaiTitle->type);
        $hentaiTitle->setLanguage($editHentaiTitle->language);
        $hentaiTitle->setEpisodes($editHentaiTitle->episodes);
        $hentaiTitle->setRating($editHentaiTitle->rating);
        $hentaiTitle->setStatusDownload($editHentaiTitle->statusDownload);
        $hentaiTitle->setStatusView($editHentaiTitle->statusView);

        $this->hentaiTitleRepository->save($hentaiTitle, true);

        return $hentaiTitle;
    }

    private function appendFansubs(HentaiTitle $hentaiTitle, array $ids): void
    {
        $fansubsToRemove = $hentaiTitle
            ->getFansubs()
            ->filter(function ($fansub) use ($ids) {
                return !in_array($fansub->getId(), $ids);
            })
        ;

        foreach ($fansubsToRemove as $fansub) {
            $hentaiTitle->removeFansub($fansub);
        }

        $notFound = [];

        foreach ($ids as $id) {
            $fansub = $this->fansubRepository->get($id);
            $fansub instanceof Fansub ? $hentaiTitle->addFansub($fansub) : $notFound[] = $id;
        }

        if ($notFound) {
            throw FansubsNotFoundException::create($notFound);
        }
    }

    private function appendTags(HentaiTitle $hentaiTitle, array $ids): void
    {
        $tagsToRemove = $hentaiTitle
            ->getTags()
            ->filter(function ($tag) use ($ids) {
                return !in_array($tag->getId(), $ids);
            })
        ;

        foreach ($tagsToRemove as $tag) {
            $hentaiTitle->removeTag($tag);
        }

        $notFound = [];

        foreach ($ids as $id) {
            $tag = $this->tagRepository->get($id);
            $tag instanceof Tag ? $hentaiTitle->addTag($tag) : $notFound[] = $id;
        }

        if ($notFound) {
            throw TagsNotFoundException::create($notFound);
        }
    }

    private function appendVideoFiles(HentaiTitle $hentaiTitle, array $videoFiles): void
    {
        if (empty($videoFiles)) {
            return;
        }

        $videoFilesToRemove = $hentaiTitle
            ->getVideoFiles()
            ->filter(function ($videoFile) use ($hentaiTitle, $videoFiles) {
                $return = !in_array($videoFile->getName(), $videoFiles);
                if ($return) {
                    $hentaiTitle->removeVideoFile($videoFile);
                }

                return $return;
            })
            ->toArray()
        ;
        $videoFilesFound = $hentaiTitle
            ->getVideoFiles()
            ->map(function ($videoFile) {
                return $videoFile->getName();
            })
            ->toArray()
        ;
        $videoFilesToAdd = array_diff($videoFiles, $videoFilesFound);

        $this
            ->videoFileRepository
            ->removeByList($videoFilesToRemove)
        ;

        foreach ($videoFilesToAdd as $filename) {
            $videoFile = (new VideoFile())->setName($filename);
            $hentaiTitle->addVideoFile($videoFile);
        }
    }
}
