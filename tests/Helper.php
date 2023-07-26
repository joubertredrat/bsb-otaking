<?php

declare(strict_types=1);

namespace App\Tests;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class Helper
{
    public const VIDEOFILE_01 = 'episode_01_[ABCDE012].mkv';
    public const VIDEOFILE_01_V2 = 'episode_01_v2_[ABCDE012].mkv';
    public const VIDEOFILE_02 = 'episode_02_[210EDCBA].mkv';

    public static function getVideoFiles(): array
    {
        return [
            self::VIDEOFILE_01,
            self::VIDEOFILE_02,
        ];
    }

    public static function getRequestMock(array $data, string $contentType = 'application/json'): Request
    {
        return new Request(
            query: [],
            request: [],
            attributes: [],
            cookies: [],
            files: [],
            server: [
                'CONTENT_TYPE' => $contentType,
            ],
            content: \json_encode($data),
        );
    }

    public static function getValidationMock(): ValidatorInterface
    {
        return Validation::createValidatorBuilder()->enableAnnotationMapping()->getValidator();
    }

    public static function getRequestStackMock(Request $request): RequestStack
    {
        $requestStack = new RequestStack();
        $requestStack->push($request);

        return $requestStack;
    }
}
