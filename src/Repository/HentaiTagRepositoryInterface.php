<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\HentaiTag;

interface HentaiTagRepositoryInterface
{
    public function save(HentaiTag $entity, bool $flush = false): void;

    public function remove(HentaiTag $entity, bool $flush = false): void;

    public function get(int $id): ?HentaiTag;

    public function getByName(string $name): ?HentaiTag;

    public function list(): array;
}
