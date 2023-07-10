<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\HentaiTagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HentaiTagRepository::class)]
#[ORM\HasLifecycleCallbacks]
class HentaiTag
{
    use Timestampable;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: HentaiTitle::class, inversedBy: 'tags')]
    private Collection $title;

    public function __construct()
    {
        $this->title = new ArrayCollection();
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

    /**
     * @return Collection<int, HentaiTitle>
     */
    public function getTitle(): Collection
    {
        return $this->title;
    }

    public function addTitle(HentaiTitle $title): self
    {
        if (!$this->title->contains($title)) {
            $this->title->add($title);
        }

        return $this;
    }

    public function removeTitle(HentaiTitle $title): self
    {
        $this->title->removeElement($title);

        return $this;
    }
}
