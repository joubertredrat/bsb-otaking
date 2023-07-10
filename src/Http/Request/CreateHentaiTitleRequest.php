<?php

declare(strict_types=1);

namespace App\Http\Request;

use App\Dto\CreateHentaiTitle;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\PositiveOrZero;
use Symfony\Component\Validator\Constraints\Type;

class CreateHentaiTitleRequest extends AbstractJsonRequest
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
        CreateHentaiTitle::TYPE_2D,
        CreateHentaiTitle::TYPE_3D,
    ])]
    public readonly string $type;

    #[NotBlank]
    #[Type('string')]
    #[Choice([
        CreateHentaiTitle::LANGUAGE_EN_US,
        CreateHentaiTitle::LANGUAGE_PT_BR,
        CreateHentaiTitle::LANGUAGE_RAW,
    ])]
    public readonly string $language;

    #[NotBlank]
    #[Type('int')]
    #[PositiveOrZero]
    public readonly int $episodes;

    #[NotBlank]
    #[Type('string')]
    #[Choice([
        CreateHentaiTitle::STATUS_DOWNLOAD_DOWNLOADING,
        CreateHentaiTitle::STATUS_DOWNLOAD_COMPLETE,
    ])]
    public readonly string $statusDownload;

    #[NotBlank]
    #[Type('string')]
    #[Choice([
        CreateHentaiTitle::STATUS_VIEW_QUEUE,
        CreateHentaiTitle::STATUS_VIEW_WATCHING,
        CreateHentaiTitle::STATUS_VIEW_DONE,
    ])]
    public readonly string $statusView;

    #[NotBlank]
    #[All([
        new Positive(),
    ])]
    public readonly array $fansubs;

    #[All([
        new Type('string'),
    ])]
    public array $files = [];

    #[All([
        new Type('string'),
    ])]
    public array $tags = [];
}
