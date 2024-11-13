<?php

declare(strict_types=1);

namespace App\Tests\Unit\Http\Request;

use App\Exception\Http\Request\AbstractJsonRequest\InvalidJsonRequestException;
use App\Http\Request\AbstractJsonRequest;
use App\Tests\Helper;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class AbstractJsonRequestTest extends TestCase
{
    public function testWithValidJsonRequest(): void
    {
        $nameExpected = 'Foo';

        $request = Helper::getRequestMock(bodyData: ['name' => $nameExpected]);
        $requestStack = Helper::getRequestStackMock($request);
        $validator = Helper::getValidationMock();

        $requestValidator = new class (
            validator: $validator,
            requestStack: $requestStack,
            convertCase: true,
        ) extends AbstractJsonRequest {
            #[NotBlank]
            #[Type('string')]
            public readonly string $name;
        };

        self::assertEquals($nameExpected, $requestValidator->name);
    }

    public function testWithInvalidContentType(): void
    {
        $this->expectException(InvalidJsonRequestException::class);

        $request = Helper::getRequestMock(bodyData: ['name' => 'foo'], contentType: 'application/other');
        $requestStack = Helper::getRequestStackMock($request);
        $validator = Helper::getValidationMock();

        new class (
            validator: $validator,
            requestStack: $requestStack,
            convertCase: true
        ) extends AbstractJsonRequest {
            #[NotBlank]
            #[Type('string')]
            public readonly string $name;
        };
    }

    public function testWithInvalidData(): void
    {
        $this->expectException(InvalidJsonRequestException::class);

        $request = Helper::getRequestMock(bodyData: ['names' => 'foo']);
        $requestStack = Helper::getRequestStackMock($request);
        $validator = Helper::getValidationMock();

        new class (
            validator: $validator,
            requestStack: $requestStack,
            convertCase: true
        ) extends AbstractJsonRequest {
            #[NotBlank]
            #[Type('string')]
            public readonly string $name;
        };
    }
}
