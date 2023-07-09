<?php

declare(strict_types=1);

namespace App\Request;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class CreateFansubRequest extends AbstractJsonRequest
{
    #[NotBlank]
    #[Type('string')]
    public readonly string $firstName;
}
