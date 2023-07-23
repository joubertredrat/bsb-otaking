<?php

declare(strict_types=1);

namespace App\Tests;

class Helper
{
    public const VIDEOFILE_01 = 'episode_01_[ABCDE012].mkv';
    public const VIDEOFILE_02 = 'episode_02_[210EDCBA].mkv';

    public static function getVideoFiles(): array
    {
        return [
            self::VIDEOFILE_01,
            self::VIDEOFILE_02,
        ];
    }
}
