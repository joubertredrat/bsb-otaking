<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\FansubRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FansubRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Fansub
{
    use PrimaryKeyable;
    use Timestampable;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: HentaiTitle::class, mappedBy: 'fansubs')]
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
            $hentaiTitle->addFansub($this);
        }

        return $this;
    }

    public function removeHentaiTitle(HentaiTitle $hentaiTitle): self
    {
        if ($this->hentaiTitles->removeElement($hentaiTitle)) {
            $hentaiTitle->removeFansub($this);
        }

        return $this;
    }
}
