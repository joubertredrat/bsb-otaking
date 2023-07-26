<?php

declare(strict_types=1);

namespace App\Tests\Exception\UseCase\EditHentaiTitle;

use App\Exception\UseCase\EditHentaiTitle\TagsNotFoundException;
use PHPUnit\Framework\TestCase;

class TagsNotFoundExceptionTest extends TestCase
{
    public function testThrowException(): void
    {
        $this->expectException(TagsNotFoundException::class);
        $this->expectExceptionMessage('Tags with IDs not found: 1, 2');

        throw TagsNotFoundException::create([1, 2]);
    }
}
