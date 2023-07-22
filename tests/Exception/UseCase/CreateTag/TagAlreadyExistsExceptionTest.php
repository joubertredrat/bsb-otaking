<?php

declare(strict_types=1);

namespace App\Tests\Exception\UseCase\CreateTag;

use App\Exception\UseCase\CreateTag\TagAlreadyExistsException;
use PHPUnit\Framework\TestCase;

class TagAlreadyExistsExceptionTest extends TestCase
{
    public function testThrowException(): void
    {
        $this->expectException(TagAlreadyExistsException::class);
        $this->expectExceptionMessage('Tag with type [ foo ] and name [ bar ] already exists');

        throw TagAlreadyExistsException::create('foo', 'bar');
    }
}
