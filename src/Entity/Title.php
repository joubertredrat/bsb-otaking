<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\TitleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TitleRepository::class)]
class Title
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

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

    #[ORM\ManyToMany(targetEntity: Fansub::class, inversedBy: 'titles')]
    private Collection $fansubs;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToMany(targetEntity: Tag::class, mappedBy: 'title')]
    private Collection $tags;

    public function __construct()
    {
        $this->fansubs = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
        $this->type = $type;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(string $language): self
    {
        $this->language = $language;

        return $this;
    }

    public function getEpisodes(): ?int
    {
        return $this->episodes;
    }

    public function setEpisodes(int $episodes): self
    {
        $this->episodes = $episodes;

        return $this;
    }

    public function getStatusDownload(): ?string
    {
        return $this->statusDownload;
    }

    public function setStatusDownload(string $statusDownload): self
    {
        $this->statusDownload = $statusDownload;

        return $this;
    }

    public function getStatusView(): ?string
    {
        return $this->statusView;
    }

    public function setStatusView(string $statusView): self
    {
        $this->statusView = $statusView;

        return $this;
    }

    /**
     * @return Collection<int, Fansub>
     */
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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
            $tag->addTitle($this);
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->removeElement($tag)) {
            $tag->removeTitle($this);
        }

        return $this;
    }
}
