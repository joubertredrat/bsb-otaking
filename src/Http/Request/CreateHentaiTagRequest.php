<?php

declare(strict_types=1);

namespace App\Http\Request;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class CreateHentaiTagRequest extends AbstractJsonRequest
{
    #[NotBlank]
    #[Type('string')]
    public readonly string $name;
}
