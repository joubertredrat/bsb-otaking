<?php

declare(strict_types=1);

namespace App\UseCase;

use App\Dto\CreateTitle as DtoCreateTitle;
use App\Entity\File;
use App\Entity\Title;
use App\Repository\FansubRepository;
use App\Repository\FileRepository;
use App\Repository\TagRepository;
use App\Repository\TitleRepository;

class CreateTitle
{
    public function __construct(
        protected FansubRepository $fansubRepository,
        protected TitleRepository $titleRepository,
        protected TagRepository $tagRepository,
        protected FileRepository $fileRepository,
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
            if (is_null($fansub)) {
                $notFound[] = $id;
                continue;
            }
            $title->addFansub($fansub);
        }

        if ($notFound) {
            // Exception
        }
    }

    private function appendTags(Title $title, array $ids): void
    {
        $notFound = [];

        foreach ($ids as $id) {
            $tag = $this->tagRepository->get($id);
            if (is_null($tag)) {
                $notFound[] = $id;
                continue;
            }
            $title->addTag($tag);
        }

        if ($notFound) {
            // Exception
        }
    }
}
