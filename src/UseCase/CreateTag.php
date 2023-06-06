<?php

declare(strict_types=1);

namespace App\UseCase;

use App\Dto\CreateTag as DtoCreateTag;
use App\Entity\Tag;
use App\Exception\UseCase\CreateTag\TagNameAlreadyExistsException;
use App\Repository\TagRepositoryInterface;

class CreateTag
{
    public function __construct(protected TagRepositoryInterface $tagRepository)
    {
    }

    public function execute(DtoCreateTag $createTag): Tag
    {
        $tagFound = $this->tagRepository->getByName($createTag->name);
        if ($tagFound instanceof Tag) {
            throw TagNameAlreadyExistsException::dispatch($createTag->name);
        }

        $tag = new Tag();
        $tag->setName($createTag->name);
        $this->tagRepository->save($tag, true);

        return $tag;
    }
}
