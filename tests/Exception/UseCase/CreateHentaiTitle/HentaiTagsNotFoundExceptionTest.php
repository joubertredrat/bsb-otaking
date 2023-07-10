<?php

declare(strict_types=1);

namespace App\Tests\Exception\UseCase\CreateHentaiTitle;

use App\Exception\UseCase\CreateHentaiTitle\HentaiTagsNotFoundException;
use PHPUnit\Framework\TestCase;

class HentaiTagsNotFoundExceptionTest extends TestCase
{
    public function testThrowException(): void
    {
        $this->expectException(HentaiTagsNotFoundException::class);
        $this->expectExceptionMessage('Tags with IDs not found: 1, 2');

        throw HentaiTagsNotFoundException::dispatch([1, 2]);
    }
}
