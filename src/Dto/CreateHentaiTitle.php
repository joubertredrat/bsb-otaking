<?php

declare(strict_types=1);

namespace App\Dto;

use App\Exception\Dto\CreateHentaiTitle\InvalidArgumentsException;

class CreateHentaiTitle
{
    public const TYPE_2D = '2D';
    public const TYPE_3D = '3D';
    public const LANGUAGE_EN_US = 'en_us';
	public const LANGUAGE_PT_BR = 'pt_br';
    public const LANGUAGE_RAW = 'raw';
    public const STATUS_DOWNLOAD_DOWNLOADING = 'downloading';
	public const STATUS_DOWNLOAD_COMPLETE = 'complete';
	public const STATUS_VIEW_QUEUE = 'queue';
	public const STATUS_VIEW_WATCHING = 'watching';
	public const STATUS_VIEW_DONE = 'done';

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
        if (!self::isValidType($this->type)) {
            $errors[] = 'type';
        }
        if (!self::isValidLanguage($this->language)) {
            $errors[] = 'language';
        }
        if ($this->episodes < 0) {
            $errors[] = 'episodes';
        }
        if (!self::isValidStatusDownload($this->statusDownload)) {
            $errors[] = 'statusDownload';
        }
        if (!self::isValidStatusView($this->statusView)) {
            $errors[] = 'statusView';
        }
        if (!self::isValidIds($this->fansubs)) {
            $errors[] = 'fansubs';
        }
        if (!self::isValidIds($this->tags)) {
            $errors[] = 'tags';
        }

        if ($errors) {
            throw InvalidArgumentsException::dispatch($errors);
        }
    }

    private static function isValidType(string $type): bool
    {
        return \in_array($type, [self::TYPE_2D, self::TYPE_3D]);
    }

    private static function isValidLanguage(string $language): bool
    {
        return \in_array($language, [self::LANGUAGE_EN_US, self::LANGUAGE_PT_BR, self::LANGUAGE_RAW]);
    }

    private static function isValidStatusDownload(string $statusDownload): bool
    {
        return \in_array(
            $statusDownload,
            [self::STATUS_DOWNLOAD_DOWNLOADING, self::STATUS_DOWNLOAD_COMPLETE],
        );
    }

    private static function isValidStatusView(string $statusView): bool
    {
        return \in_array(
            $statusView,
            [self::STATUS_VIEW_QUEUE, self::STATUS_VIEW_WATCHING, self::STATUS_VIEW_DONE],
        );
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
