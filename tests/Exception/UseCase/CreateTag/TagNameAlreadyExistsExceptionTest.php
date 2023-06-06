<?php

declare(strict_types=1);

namespace App\Tests\Exception\UseCase\CreateTag;

use App\Exception\UseCase\CreateTag\TagNameAlreadyExistsException;
use PHPUnit\Framework\TestCase;

class TagNameAlreadyExistsExceptionTest extends TestCase
{
    public function testThrowException(): void
    {
        $this->expectException(TagNameAlreadyExistsException::class);
        $this->expectExceptionMessage('Tag with name foo already exists');

        throw TagNameAlreadyExistsException::dispatch('foo');
    }
}
