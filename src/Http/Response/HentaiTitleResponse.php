<?php

declare(strict_types=1);

namespace App\Http\Response;

use App\Entity\HentaiTitle;
use App\Helper\DateTime;
use JsonSerializable;

class HentaiTitleResponse implements JsonSerializable
{
    public function __construct(public readonly HentaiTitle $hentaiTitle)
    {
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->hentaiTitle->getId(),
            'name' => $this->hentaiTitle->getName(),
            'alternativeNames' => $this->hentaiTitle->getAlternativeNames(),
            'type' => $this->hentaiTitle->getType(),
            'language' => $this->hentaiTitle->getLanguage(),
            'episodes' => $this->hentaiTitle->getEpisodes(),
            'statusDownload' => $this->hentaiTitle->getStatusDownload(),
            'statusView' => $this->hentaiTitle->getStatusView(),
            'fansubs' => $this->getFansubs(),
            'tags' => $this->getTags(),
            'files' => $this->getFiles(),
            'createdAt' => DateTime::getString($this->hentaiTitle->getCreatedAt()),
            'updatedAt' => DateTime::getString($this->hentaiTitle->getUpdatedAt()),
        ];
    }

    private function getFansubs(): array
    {
        $fansubs = [];

        foreach ($this->hentaiTitle->getFansubs()->toArray() as $fansub) {
            $fansubs[] = [
                'id' => $fansub->getId(),
                'name' => $fansub->getName(),
            ];
        }

        return $fansubs;
    }

    private function getTags(): array
    {
        $tags = [];

        foreach ($this->hentaiTitle->getTags()->toArray() as $tag) {
            $tags[] = $tag->getName();
        }

        return $tags;
    }

    private function getFiles(): array
    {
        $files = [];

        foreach ($this->hentaiTitle->getFiles()->toArray() as $file) {
            $files[] = $file->getName();
        }

        return $files;
    }
}
