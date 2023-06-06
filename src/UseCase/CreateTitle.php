<?php

declare(strict_types=1);

namespace App\UseCase;

use App\Dto\CreateTitle as DtoCreateTitle;
use App\Entity\Fansub;
use App\Entity\File;
use App\Entity\Tag;
use App\Entity\Title;
use App\Exception\UseCase\CreateTitle\FansubsNotFoundException;
use App\Exception\UseCase\CreateTitle\TagsNotFoundException;
use App\Repository\FansubRepositoryInterface;
use App\Repository\TagRepositoryInterface;
use App\Repository\TitleRepositoryInterface;

class CreateTitle
{
    public function __construct(
        protected TitleRepositoryInterface $titleRepository,
        protected FansubRepositoryInterface $fansubRepository,
        protected TagRepositoryInterface $tagRepository,
    ) {
    }

    public function execute(DtoCreateTitle $createTitle): Title
    {
        $title = new Title();

        $this->appendFansubs($title, $createTitle->fansubs);
        $this->appendTags($title, $createTitle->tags);

        $title->setName($createTitle->name);
        $title->setAlternativeNames($createTitle->alternativeNames);
        $title->setType($createTitle->type);
        $title->setLanguage($createTitle->language);
        $title->setEpisodes($createTitle->episodes);
        $title->setStatusDownload($createTitle->statusDownload);
        $title->setStatusView($createTitle->statusView);

        foreach ($createTitle->files as $filename) {
            $file = new File();
            $file->setName($filename);
            $title->addFile($file);
        }

        $this->titleRepository->save($title, true);
        return $title;
    }

    private function appendFansubs(Title $title, array $ids): void
    {
        $notFound = [];

        foreach ($ids as $id) {
            $fansub = $this->fansubRepository->get($id);
            if (!$fansub instanceof Fansub) {
                $notFound[] = $id;
                continue;
            }
            $title->addFansub($fansub);
        }

        if ($notFound) {
            throw FansubsNotFoundException::dispatch($notFound);
        }
    }

    private function appendTags(Title $title, array $ids): void
    {
        $notFound = [];

        foreach ($ids as $id) {
            $tag = $this->tagRepository->get($id);
            if (!$tag instanceof Tag) {
                $notFound[] = $id;
                continue;
            }
            $title->addTag($tag);
        }

        if ($notFound) {
            throw TagsNotFoundException::dispatch($notFound);
        }
    }
}
