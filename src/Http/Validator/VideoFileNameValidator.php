<?php

declare(strict_types=1);

namespace App\Http\Validator;

use App\Entity\VideoFile;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class VideoFileNameValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof VideoFileName) {
            throw new UnexpectedTypeException($constraint, VideoFileName::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!VideoFile::isValidName($value)) {
            $this
                ->context
                ->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation()
            ;
        }
    }
}
