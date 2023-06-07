<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Title;

interface TitleRepositoryInterface
{
    public function save(Title $entity, bool $flush = false): void;

    public function remove(Title $entity, bool $flush = false): void;

    public function list(): array;
}
