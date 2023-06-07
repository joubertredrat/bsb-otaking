<?php

declare(strict_types=1);

namespace App\UseCase;

use App\Repository\TitleRepositoryInterface;

class ListTitles
{
    public function __construct(protected TitleRepositoryInterface $titleRepository)
    {
    }

    public function execute(): array
    {
        return $this->titleRepository->list();
    }
}
