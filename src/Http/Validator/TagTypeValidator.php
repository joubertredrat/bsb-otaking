<?php

declare(strict_types=1);

namespace App\Http\Validator;

use App\Entity\Tag;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class TagTypeValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof TagType) {
            throw new UnexpectedTypeException($constraint, TagType::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!Tag::isValidType($value)) {
            $this
                ->context
                ->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->setParameter('{{ availableValues }}', implode(', ', Tag::getTypesAvailable()))
                ->addViolation()
            ;
        }
    }
}
