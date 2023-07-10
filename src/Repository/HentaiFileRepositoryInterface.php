<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\HentaiFile;

interface HentaiFileRepositoryInterface
{
    public function save(HentaiFile $entity, bool $flush = false): void;

    public function remove(HentaiFile $entity, bool $flush = false): void;
}
