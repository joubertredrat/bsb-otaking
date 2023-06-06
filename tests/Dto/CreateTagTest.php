<?php

declare(strict_types=1);

namespace App\Tests\Dto;

use App\Dto\CreateTag;
use App\Exception\Dto\CreateTag\InvalidNameException;
use PHPUnit\Framework\TestCase;

class CreateTagTest extends TestCase
{
    public function testCreateTag(): void
    {
        $nameExpected = 'foo:bar';
        $createTag = new CreateTag(name: $nameExpected);

        self::assertEquals($nameExpected, $createTag->name);
    }

    public function testCreateTagWithInvalidName(): void
    {
        $this->expectException(InvalidNameException::class);
        new CreateTag(name: 'foo-bar');
    }
}
