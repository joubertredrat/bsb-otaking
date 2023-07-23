<?php

declare(strict_types=1);

namespace App\Tests\Http\Validator;

use App\Http\Validator\TagName;
use App\Http\Validator\TagNameValidator;
use Symfony\Component\Validator\Constraints\Blank;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class TagNameValidatorTest extends ConstraintValidatorTestCase
{
    protected function createValidator(): TagNameValidator
    {
        return new TagNameValidator();
    }

    public function testValidate(): void
    {
        $this
            ->validator
            ->validate('foo', new TagName())
        ;

        $this->assertNoViolation();
    }

    public function testValidateWithInvalidConstraint(): void
    {
        $this->expectException(UnexpectedTypeException::class);

        $this
            ->validator
            ->validate('foo', new Blank())
        ;
    }

    public function testValidateWithNullValue(): void
    {
        $this
            ->validator
            ->validate(null, new TagName())
        ;

        $this->assertNoViolation();
    }

    public function testValidateWithInvalidValue(): void
    {
        $constraint = new TagName();

        $this
            ->validator
            ->validate('FO0!', $constraint)
        ;

        $this
            ->buildViolation($constraint->message)
            ->setParameter('{{ value }}', 'FO0!')
            ->assertRaised()
        ;
    }
}
