<?php

declare(strict_types=1);

namespace App\UseCase;

use App\Repository\FansubRepositoryInterface;

class ListFansubs
{
    public function __construct(protected FansubRepositoryInterface $fansubRepository)
    {
    }

    public function execute(): array
    {
        return $this->fansubRepository->list();
    }
}
