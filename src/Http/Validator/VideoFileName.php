<?php

declare(strict_types=1);

namespace App\Http\Validator;

use Symfony\Component\Validator\Constraint;

class VideoFileName extends Constraint
{
    public string $message = 'Expected {{ value }} to be a valid video filename with valid CRC32';

    public string $mode = 'strict';
}
