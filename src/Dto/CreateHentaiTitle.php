<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\HentaiTitle;
use App\Exception\Dto\CreateHentaiTitle\InvalidArgumentsException;

class CreateHentaiTitle
{
    use HentaiTitleTrait;

    public function __construct(
        public readonly string $name,
        public readonly array $alternativeNames,
        public readonly string $type,
        public readonly string $language,
        public readonly int $episodes,
        public readonly int $rating,
        public readonly string $statusDownload,
        public readonly string $statusView,
        public readonly array $fansubs,
        public readonly array $tags,
        public readonly array $videoFiles,
    ) {
        $errors = [];
        if ($name === '') {
            $errors[] = 'name';
        }
        if (!HentaiTitle::isValidType($this->type)) {
            $errors[] = 'type';
        }
        if (!HentaiTitle::isValidLanguage($this->language)) {
            $errors[] = 'language';
        }
        if (!HentaiTitle::isValidEpisodes($this->episodes)) {
            $errors[] = 'episodes';
        }
        if (!HentaiTitle::isValidRating($this->rating)) {
            $errors[] = 'rating';
        }
        if (!HentaiTitle::isValidStatusDownload($this->statusDownload)) {
            $errors[] = 'statusDownload';
        }
        if (!HentaiTitle::isValidStatusView($this->statusView)) {
            $errors[] = 'statusView';
        }
        if (!self::isValidIds($this->fansubs)) {
            $errors[] = 'fansubs';
        }
        if (!self::isValidIds($this->tags)) {
            $errors[] = 'tags';
        }
        if (!self::isValidVideoFiles($this->videoFiles)) {
            $errors[] = 'videoFiles';
        }

        if ($errors) {
            throw InvalidArgumentsException::create($errors);
        }
    }
}
