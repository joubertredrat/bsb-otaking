<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Fansub;

interface FansubRepositoryInterface
{
    public function save(Fansub $entity, bool $flush = false): void;

    public function remove(Fansub $entity, bool $flush = false): void;

    public function get(int $id): ?Fansub;
}
