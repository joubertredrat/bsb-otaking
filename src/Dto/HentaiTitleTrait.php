<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\VideoFile;

trait HentaiTitleTrait
{
    public static function isValidId(int $id): bool
    {
        return $id > 0;
    }

    public static function isValidIds(array $ids): bool
    {
        foreach ($ids as $id) {
            if (!self::isValidId($id)) {
                return false;
            }
        }

        return true;
    }


    public static function isValidVideoFiles(array $videoFiles): bool
    {
        foreach ($videoFiles as $videoFile) {
            if (!VideoFile::isValidName($videoFile)) {
                return false;
            }
        }

        return true;
    }
}
