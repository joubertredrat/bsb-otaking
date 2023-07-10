<?php

declare(strict_types=1);

namespace App\UseCase;

use App\Repository\HentaiTagRepositoryInterface;

class ListHentaiTags
{
    public function __construct(
        protected HentaiTagRepositoryInterface $hentaiTagRepository,
    ) {
    }

    public function execute(): array
    {
        return $this->hentaiTagRepository->list();
    }
}
