<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Tag;

interface TagRepositoryInterface
{
    public function save(Tag $entity, bool $flush = false): void;

    public function remove(Tag $entity, bool $flush = false): void;

    public function get(int $id): ?Tag;

    public function getByName(string $name): ?Tag;

    public function list(): array;
}
