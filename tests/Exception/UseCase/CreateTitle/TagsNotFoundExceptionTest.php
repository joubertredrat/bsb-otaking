<?php

declare(strict_types=1);

namespace App\Tests\Exception\UseCase\CreateTitle;

use App\Exception\UseCase\CreateTitle\TagsNotFoundException;
use PHPUnit\Framework\TestCase;

class TagsNotFoundExceptionTest extends TestCase
{
    public function testThrowException(): void
    {
        $this->expectException(TagsNotFoundException::class);
        $this->expectExceptionMessage('Tags with IDs not found: 1, 2');

        throw TagsNotFoundException::dispatch([1, 2]);
    }
}
