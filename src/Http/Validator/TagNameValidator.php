<?php

declare(strict_types=1);

namespace App\Http\Validator;

use App\Entity\Tag;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class TagNameValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof TagName) {
            throw new UnexpectedTypeException($constraint, TagName::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!Tag::isValidName($value)) {
            $this
                ->context
                ->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation()
            ;
        }
    }
}
