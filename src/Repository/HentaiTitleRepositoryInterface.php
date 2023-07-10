<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\HentaiTitle;

interface HentaiTitleRepositoryInterface
{
    public function save(HentaiTitle $entity, bool $flush = false): void;

    public function remove(HentaiTitle $entity, bool $flush = false): void;

    public function list(): array;
}
