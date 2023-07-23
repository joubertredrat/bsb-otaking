<?php

declare(strict_types=1);

namespace App\Tests\Http\Validator;

use App\Entity\Tag;
use App\Http\Validator\TagType;
use App\Http\Validator\TagTypeValidator;
use Symfony\Component\Validator\Constraints\Blank;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class TagTypeValidatorTest extends ConstraintValidatorTestCase
{
    protected function createValidator(): TagTypeValidator
    {
        return new TagTypeValidator();
    }

    public function testValidate(): void
    {
        $this
            ->validator
            ->validate(Tag::TYPE_ALL, new TagType())
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
            ->validate(null, new TagType())
        ;

        $this->assertNoViolation();
    }

    public function testValidateWithInvalidValue(): void
    {
        $constraint = new TagType();

        $this
            ->validator
            ->validate('foo', $constraint)
        ;

        $this
            ->buildViolation($constraint->message)
            ->setParameter('{{ value }}', 'foo')
            ->setParameter('{{ availableValues }}', implode(', ', Tag::getTypesAvailable()))
            ->assertRaised()
        ;
    }
}
