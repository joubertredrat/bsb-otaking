<?php

declare(strict_types=1);

namespace App\Entity;

use App\Exception\Entity\HentaiTitle\InvalidEpisodesException;
use App\Exception\Entity\HentaiTitle\InvalidLanguageException;
use App\Exception\Entity\HentaiTitle\InvalidStatusDownloadException;
use App\Exception\Entity\HentaiTitle\InvalidStatusViewException;
use App\Exception\Entity\HentaiTitle\InvalidTypeException;
use App\Repository\HentaiTitleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HentaiTitleRepository::class)]
#[ORM\HasLifecycleCallbacks]
class HentaiTitle
{
    use PrimaryKey;
    use Timestampable;

    public const TYPE_2D = '2D';
    public const TYPE_3D = '3D';
    public const LANGUAGE_EN_US = 'en_us';
    public const LANGUAGE_PT_BR = 'pt_br';
    public const LANGUAGE_RAW = 'raw';
    public const STATUS_DOWNLOAD_DOWNLOADING = 'downloading';
    public const STATUS_DOWNLOAD_COMPLETE = 'complete';
    public const STATUS_VIEW_QUEUE = 'queue';
    public const STATUS_VIEW_WATCHING = 'watching';
    public const STATUS_VIEW_DONE = 'done';

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY, nullable: true)]
    private array $alternativeNames = [];

    #[ORM\Column(length: 5)]
    private ?string $type = null;

    #[ORM\Column(length: 10)]
    private ?string $language = null;

    #[ORM\Column]
    private ?int $episodes = null;

    #[ORM\Column(length: 20)]
    private ?string $statusDownload = null;

    #[ORM\Column(length: 20)]
    private ?string $statusView = null;

    #[ORM\ManyToMany(targetEntity: Fansub::class, inversedBy: 'hentaiTitles', cascade: ['remove'])]
    private Collection $fansubs;

    #[ORM\ManyToMany(targetEntity: Tag::class, mappedBy: 'hentaiTitles', cascade: ['remove'])]
    private Collection $tags;

    #[ORM\ManyToMany(targetEntity: VideoFile::class, mappedBy: 'hentaiTitles', cascade: ['persist', 'remove'])]
    #[ORM\OrderBy(['name' => 'ASC'])]
    private Collection $videoFiles;

    public function __construct()
    {
        $this->fansubs = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->videoFiles = new ArrayCollection();
    }
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAlternativeNames(): array
    {
        return $this->alternativeNames;
    }

    public function setAlternativeNames(?array $alternativeNames): self
    {
        $this->alternativeNames = $alternativeNames;

        return $this;
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

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(string $language): self
    {
        if (!self::isValidLanguage($language)) {
            throw InvalidLanguageException::create($language, self::getLanguagesAvailable());
        }
        $this->language = $language;

        return $this;
    }

    public function getEpisodes(): ?int
    {
        return $this->episodes;
    }

    public function setEpisodes(int $episodes): self
    {
        if (!self::isValidEpisodes($episodes)) {
            throw InvalidEpisodesException::create($episodes);
        }
        $this->episodes = $episodes;

        return $this;
    }

    public function getStatusDownload(): ?string
    {
        return $this->statusDownload;
    }

    public function setStatusDownload(string $statusDownload): self
    {
        if (!self::isValidStatusDownload($statusDownload)) {
            throw InvalidStatusDownloadException::create($statusDownload, self::getStatusesDownloadAvailable());
        }
        $this->statusDownload = $statusDownload;

        return $this;
    }

    public function getStatusView(): ?string
    {
        return $this->statusView;
    }

    public function setStatusView(string $statusView): self
    {
        if (!self::isValidStatusView($statusView)) {
            throw InvalidStatusViewException::create($statusView, self::getStatusesViewAvailable());
        }
        $this->statusView = $statusView;

        return $this;
    }

    public function getFansubs(): Collection
    {
        return $this->fansubs;
    }

    public function addFansub(Fansub $fansub): self
    {
        if (!$this->fansubs->contains($fansub)) {
            $this->fansubs->add($fansub);
        }

        return $this;
    }

    public function removeFansub(Fansub $fansub): self
    {
        $this->fansubs->removeElement($fansub);

        return $this;
    }

    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
            $tag->addHentaiTitle($this);
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->removeElement($tag)) {
            $tag->removeHentaiTitle($this);
        }

        return $this;
    }

    public function getVideoFiles(): Collection
    {
        return $this->videoFiles;
    }

    public function addVideoFile(VideoFile $videoFile): self
    {
        if (!$this->videoFiles->contains($videoFile)) {
            $this->videoFiles->add($videoFile);
            $videoFile->addHentaiTitle($this);
        }

        return $this;
    }

    public function removeVideoFile(VideoFile $videoFile): self
    {
        if ($this->videoFiles->removeElement($videoFile)) {
            $videoFile->removeHentaiTitle($this);
        }

        return $this;
    }

    public static function isValidType(string $type): bool
    {
        return in_array($type, self::getTypesAvailable());
    }

    public static function getTypesAvailable(): array
    {
        return [
            self::TYPE_2D,
            self::TYPE_3D,
        ];
    }

    public static function isValidEpisodes(int $episodes): bool
    {
        return $episodes >= 0;
    }

    public static function isValidLanguage(string $language): bool
    {
        return in_array($language, self::getLanguagesAvailable());
    }

    public static function getLanguagesAvailable(): array
    {
        return [
            self::LANGUAGE_EN_US,
            self::LANGUAGE_PT_BR,
            self::LANGUAGE_RAW,
        ];
    }

    public static function isValidStatusDownload(string $statusDownload): bool
    {
        return in_array($statusDownload, self::getStatusesDownloadAvailable());
    }

    public static function getStatusesDownloadAvailable(): array
    {
        return [
            self::STATUS_DOWNLOAD_DOWNLOADING,
            self::STATUS_DOWNLOAD_COMPLETE,
        ];
    }

    public static function isValidStatusView(string $statusView): bool
    {
        return in_array($statusView, self::getStatusesViewAvailable());
    }

    public static function getStatusesViewAvailable(): array
    {
        return [
            self::STATUS_VIEW_QUEUE,
            self::STATUS_VIEW_WATCHING,
            self::STATUS_VIEW_DONE,
        ];
    }
}
