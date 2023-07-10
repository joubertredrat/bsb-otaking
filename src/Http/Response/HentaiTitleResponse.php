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
            'createdAt' => DateTime::getString($this->hentaiTitle->getCreatedAt()),
            'updatedAt' => DateTime::getString($this->hentaiTitle->getUpdatedAt()),
        ];
    }
}
