<?php

declare(strict_types=1);

namespace App\Http\Request;

use App\Exception\Http\Request\AbstractJsonRequest\InvalidJsonRequestException;
use Jawira\CaseConverter\Convert;
use ReflectionClass;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractJsonRequest
{
    private const FORMAT_JSON = 'json';

    public function __construct(
        protected ValidatorInterface $validator,
        protected RequestStack $requestStack,
        protected bool $convertCase = false,
    ) {
        $this->populate();
        $this->validate();
    }

    public function getRequest(): Request
    {
        return $this->requestStack->getCurrentRequest();
    }

    protected function populate(): void
    {
        $request = $this->getRequest();
        if (!self::isValidFormat($request)) {
            throw InvalidJsonRequestException::create(['Expected application/json on header Content-Type request']);
        }

        $reflection = new ReflectionClass($this);

        foreach ($request->toArray() as $property => $value) {
            $attribute = $this->camelCase($property);
            if (property_exists($this, $attribute)) {
                $reflectionProperty = $reflection->getProperty($attribute);
                $reflectionProperty->setValue($this, $value);
            }
        }
    }

    protected function validate(): void
    {
        $violations = $this->validator->validate($this);
        if (count($violations) < 1) {
            return;
        }

        $errors = [];

        /** @var \Symfony\Component\Validator\ConstraintViolation */
        foreach ($violations as $violation) {
            $attribute = $this->snakeCase($violation->getPropertyPath());
            $errors[] = [
                'property' => $attribute,
                'value' => $violation->getInvalidValue(),
                'message' => $violation->getMessage(),
            ];
        }

        throw InvalidJsonRequestException::create($errors);
    }

    private static function isValidFormat(Request $request): bool
    {
        return \in_array($request->getContentTypeFormat(), self::getFormatsAvailable());
    }

    private static function getFormatsAvailable(): array
    {
        return [self::FORMAT_JSON];
    }

    private function camelCase(string $field): string
    {
        return $this->convertCase ? (new Convert($field))->toCamel() : $field;
    }

    private function snakeCase(string $field): string
    {
        return $this->convertCase ? (new Convert($field))->toSnake() : $field;
    }
}
