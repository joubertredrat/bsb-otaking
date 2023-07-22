<?php

declare(strict_types=1);

namespace App\Http\Request;

use App\Http\Validator\TagName;
use App\Http\Validator\TagType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class CreateTagRequest extends AbstractJsonRequest
{
    #[NotBlank()]
    #[Type('string')]
    #[TagType()]
    public readonly string $type;

    #[NotBlank()]
    #[Type('string')]
    #[TagName()]
    public readonly string $name;
}
