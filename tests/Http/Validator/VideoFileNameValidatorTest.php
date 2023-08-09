<?php

declare(strict_types=1);

namespace App\Tests\Http\Validator;

use App\Http\Validator\VideoFileName;
use App\Http\Validator\VideoFileNameValidator;
use App\Tests\Helper;
use Symfony\Component\Validator\Constraints\Blank;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class VideoFileNameValidatorTest extends ConstraintValidatorTestCase
{
    protected function createValidator(): ConstraintValidatorInterface
    {
        return new VideoFileNameValidator();
    }

    public function testValidate(): void
    {
        $this
            ->validator
            ->validate(Helper::VIDEOFILE_01, new VideoFileName())
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
            ->validate(null, new VideoFileName())
        ;

        $this->assertNoViolation();
    }

    public function testValidateWithInvalidValue(): void
    {
        $constraint = new VideoFileName();

        $this
            ->validator
            ->validate('foo', $constraint)
        ;

        $this
            ->buildViolation($constraint->message)
            ->setParameter('{{ value }}', 'foo')
            ->assertRaised()
        ;
    }
}
