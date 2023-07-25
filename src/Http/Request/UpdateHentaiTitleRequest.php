<?php

declare(strict_types=1);

namespace App\Http\Request;

use App\Entity\HentaiTitle;
use App\Http\Validator\VideoFileName;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\PositiveOrZero;
use Symfony\Component\Validator\Constraints\Type;

class UpdateHentaiTitleRequest extends AbstractJsonRequest
{
    #[NotBlank]
    #[Type('string')]
    public readonly string $name;

    #[All([
        new Type('string'),
    ])]
    public array $alternativeNames = [];

    #[NotBlank]
    #[Type('string')]
    #[Choice(options: [
        HentaiTitle::TYPE_2D,
        HentaiTitle::TYPE_3D,
    ])]
    public readonly string $type;

    #[NotBlank]
    #[Type('string')]
    #[Choice([
        HentaiTitle::LANGUAGE_EN_US,
        HentaiTitle::LANGUAGE_PT_BR,
        HentaiTitle::LANGUAGE_RAW,
    ])]
    public readonly string $language;

    #[NotBlank]
    #[Type('int')]
    #[PositiveOrZero]
    public readonly int $episodes;

    #[NotBlank]
    #[Type('string')]
    #[Choice([
        HentaiTitle::STATUS_DOWNLOAD_DOWNLOADING,
        HentaiTitle::STATUS_DOWNLOAD_COMPLETE,
    ])]
    public readonly string $statusDownload;

    #[NotBlank]
    #[Type('string')]
    #[Choice([
        HentaiTitle::STATUS_VIEW_QUEUE,
        HentaiTitle::STATUS_VIEW_WATCHING,
        HentaiTitle::STATUS_VIEW_DONE,
    ])]
    public readonly string $statusView;

    #[NotBlank]
    #[All([
        new Type('int'),
        new Positive(),
    ])]
    public readonly array $fansubs;

    #[All([
        new Type('int'),
        new Positive(),
    ])]
    public array $tags = [];

    #[All([
        new Type('string'),
        new VideoFileName(),
    ])]
    public array $videoFiles = [];
}
