<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Tag;

interface TagRepositoryInterface
{
    public function save(Tag $entity, bool $flush = false): void;

    public function remove(Tag $entity, bool $flush = false): void;

    public function get(int $id): ?Tag;

    public function getByTypeName(string $type, string $name): ?Tag;

    public function list(PaginationSQL $pagination, string $tagTypeName): array;

    public function countAll(string $tagTypeName): int;
}
