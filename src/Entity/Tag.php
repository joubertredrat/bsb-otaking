<?php

declare(strict_types=1);

namespace App\Entity;

use App\Exception\Entity\Tag\InvalidNameException;
use App\Exception\Entity\Tag\InvalidTypeException;
use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TagRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Tag
{
    use PrimaryKey;
    use Timestampable;

    public const TYPE_ANIME = 'anime';
    public const TYPE_HENTAI = 'hentai';
    public const TYPE_ALL = 'all';
    public const NAME_REGEX = '/^[a-z0-9]+$/';

    #[ORM\Column(length: 20)]
    private ?string $type = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: HentaiTitle::class, inversedBy: 'tags')]
    private Collection $hentaiTitles;

    public function __construct()
    {
        $this->hentaiTitles = new ArrayCollection();
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        if (!self::isValidType($type)) {
            throw InvalidTypeException::create($type, self::getTypesAvailable());
        }

        $this->type = $type;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        if (!self::isValidName($name)) {
            throw InvalidNameException::create($name);
        }

        $this->name = $name;

        return $this;
    }

    public function getResourceName(): string
    {
        return sprintf('%s:%s', $this->getType(), $this->getName());
    }

    public function getHentaiTitles(): Collection
    {
        return $this->hentaiTitles;
    }

    public function addHentaiTitle(HentaiTitle $hentaiTitle): self
    {
        if (!$this->hentaiTitles->contains($hentaiTitle)) {
            $this->hentaiTitles->add($hentaiTitle);
        }

        return $this;
    }

    public function removeHentaiTitle(HentaiTitle $hentaiTitle): self
    {
        $this->hentaiTitles->removeElement($hentaiTitle);

        return $this;
    }

    public static function isValidType(string $type): bool
    {
        return in_array($type, self::getTypesAvailable());
    }

    public static function getTypesAvailable(): array
    {
        return [
            self::TYPE_ANIME,
            self::TYPE_HENTAI,
            self::TYPE_ALL,
        ];
    }

    public static function isValidName(string $name): bool
    {
        return (bool) preg_match_all(self::NAME_REGEX, $name);
    }
}
