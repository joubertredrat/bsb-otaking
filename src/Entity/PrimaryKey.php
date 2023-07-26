<?php

declare(strict_types=1);

namespace App\Entity;

use App\Exception\Entity\PrimaryKeyable\InvalidPrimaryKeyException;
use Doctrine\ORM\Mapping as ORM;

trait PrimaryKey
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        if (!self::isValidId($id)) {
            throw InvalidPrimaryKeyException::create($id);
        }
        $this->id = $id;

        return $this;
    }

    public static function isValidId(int $id): bool
    {
        return $id > 0;
    }
}
