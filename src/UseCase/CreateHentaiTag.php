<?php

declare(strict_types=1);

namespace App\UseCase;

use App\Dto\CreateHentaiTag as DtoCreateHentaiTag;
use App\Entity\HentaiTag;
use App\Exception\UseCase\CreateHentaiTag\HentaiTagNameAlreadyExistsException;
use App\Repository\HentaiTagRepositoryInterface;

class CreateHentaiTag
{
    public function __construct(
        protected HentaiTagRepositoryInterface $hentaiTagRepository,
    ) {
    }

    public function execute(DtoCreateHentaiTag $createHentaiTag): HentaiTag
    {
        $hentaiTagFound = $this->hentaiTagRepository->getByName($createHentaiTag->name);
        if ($hentaiTagFound instanceof HentaiTag) {
            throw HentaiTagNameAlreadyExistsException::dispatch($createHentaiTag->name);
        }

        $hentaiTag = new HentaiTag();
        $hentaiTag->setName($createHentaiTag->name);
        $this->hentaiTagRepository->save($hentaiTag, true);

        return $hentaiTag;
    }
}
