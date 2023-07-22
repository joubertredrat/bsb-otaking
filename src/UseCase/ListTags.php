<?php

declare(strict_types=1);

namespace App\UseCase;

use App\Repository\TagRepositoryInterface;

class ListTags
{
    public function __construct(
        protected TagRepositoryInterface $tagRepository,
    ) {
    }

    public function execute(): array
    {
        return $this->tagRepository->list();
    }
}
