<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\HentaiTitle;
use App\Exception\Dto\CreateHentaiTitle\InvalidArgumentsException;

class CreateHentaiTitle
{
    public function __construct(
        public readonly string $name,
        public readonly array $alternativeNames,
        public readonly string $type,
        public readonly string $language,
        public readonly int $episodes,
        public readonly string $statusDownload,
        public readonly string $statusView,
        public readonly array $fansubs,
        public readonly array $files,
        public readonly array $tags,
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
        if ($this->episodes < 0) {
            $errors[] = 'episodes';
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

        if ($errors) {
            throw InvalidArgumentsException::create($errors);
        }
    }

    private static function isValidIds(array $ids): bool
    {
        foreach ($ids as $id) {
            if ($id < 1) {
                return false;
            }
        }

        return true;
    }
}
