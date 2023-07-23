<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\HentaiFileRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HentaiFileRepository::class)]
#[ORM\HasLifecycleCallbacks]
class HentaiFile
{
    use PrimaryKeyable;
    use Timestampable;

    #[ORM\Column(length: 750)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'files')]
    #[ORM\JoinColumn(nullable: false)]
    private ?HentaiTitle $title = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getTitle(): ?HentaiTitle
    {
        return $this->title;
    }

    public function setTitle(?HentaiTitle $title): self
    {
        $this->title = $title;

        return $this;
    }
}
