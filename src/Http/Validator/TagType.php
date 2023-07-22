<?php

declare(strict_types=1);

namespace App\Http\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class TagType extends Constraint
{
    public string $message = 'Expected {{ value }} to be one of values: {{ availableValues }}';

    public string $mode = 'strict';
}
