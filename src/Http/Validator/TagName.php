<?php

declare(strict_types=1);

namespace App\Http\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class TagName extends Constraint
{
    public string $message = 'Expected {{ value }} to be a valid tag name';

    public string $mode = 'strict';
}
