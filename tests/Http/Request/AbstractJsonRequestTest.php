<?php

declare(strict_types=1);

namespace App\Tests\Http\Request;

use App\Http\Request\AbstractJsonRequest;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AbstractJsonRequestTest extends TestCase
{
    public function testWithValidJsonRequest(): void
    {
        $nameExpected = 'Foo';

        $request = new Request(
            query: [],
            request: [],
            attributes: [],
            cookies: [],
            files: [],
            server: [
                'CONTENT_TYPE' => 'application/json',
            ],
            content: \json_encode([
                'name' => $nameExpected,
            ]),
        );

        $requestStack = $this->getRequestStackMock($request);
        $validator = $this->getValidationMock();

        $requestValidator = new class (validator: $validator, requestStack: $requestStack) extends AbstractJsonRequest {
            #[NotBlank]
            #[Type('string')]
            public readonly string $name;
        };

        self::assertEquals($nameExpected, $requestValidator->name);
    }

    private function getValidationMock(): ValidatorInterface
    {
        return Validation::createValidatorBuilder()->enableAnnotationMapping()->getValidator();
    }

    private function getRequestStackMock(Request $request): RequestStack
    {
        $requestStack = new RequestStack();
        $requestStack->push($request);

        return $requestStack;
    }
}
