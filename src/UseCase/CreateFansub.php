<?php

declare(strict_types=1);

namespace App\UseCase;

use App\Dto\CreateFansub as DtoCreateFansub;
use App\Entity\Fansub;
use App\Exception\UseCase\CreateFansub\FansubNameAlreadyExistsException;
use App\Repository\FansubRepositoryInterface;

class CreateFansub
{
    public function __construct(protected FansubRepositoryInterface $fansubRepository)
    {
    }

    public function execute(DtoCreateFansub $createFansub): Fansub
    {
        $fansubFound = $this->fansubRepository->getByName($createFansub->name);
        if ($fansubFound instanceof Fansub) {
            throw FansubNameAlreadyExistsException::create($createFansub->name);
        }

        $fansub = new Fansub();
        $fansub->setName($createFansub->name);
        $this->fansubRepository->save($fansub, true);

        return $fansub;
    }
}
