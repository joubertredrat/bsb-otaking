<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\VideoFile;

interface VideoFileRepositoryInterface
{
    public function save(VideoFile $entity, bool $flush = false): void;
}
