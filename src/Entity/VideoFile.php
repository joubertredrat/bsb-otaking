<?php

declare(strict_types=1);

namespace App\Entity;

use App\Exception\Entity\VideoFile\InvalidNameException;
use App\Repository\VideoFileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VideoFileRepository::class)]
#[ORM\HasLifecycleCallbacks]
class VideoFile
{
    use PrimaryKey;
    use Timestampable;

    public const EXTENSION_MKV = 'mkv';
    public const EXTENSION_MP4 = 'mp4';
    public const EXTENSION_AVI = 'avi';

    #[ORM\Column(type: Types::TEXT)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: HentaiTitle::class, inversedBy: 'videoFiles')]
    private Collection $hentaiTitles;

    public function __construct()
    {
        $this->hentaiTitles = new ArrayCollection();
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

    public static function isValidName(string $name): bool
    {
        return (bool) preg_match_all(self::getNameRegex(), $name);
    }

    public static function getNameRegex(): string
    {
        return sprintf(
            '/^(.*?)[0-9a-fA-f]{8}(.*?).(%s)$/',
            implode('|', self::getExtenionsAvailable()),
        );
    }

    public static function getExtenionsAvailable(): array
    {
        return [
            self::EXTENSION_MKV,
            self::EXTENSION_MP4,
            self::EXTENSION_AVI,
        ];
    }
}
