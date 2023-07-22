<?php

declare(strict_types=1);

namespace App\Tests\Dto;

use App\Dto\CreateTag;
use App\Entity\Tag;
use App\Exception\Dto\CreateTag\InvalidArgumentsException;
use PHPUnit\Framework\TestCase;

class CreateTagTest extends TestCase
{
    public function testCreateTag(): void
    {
        $typeExpected = Tag::TYPE_ALL;
        $nameExpected = 'foo';
        $createTag = new CreateTag(type: $typeExpected, name: $nameExpected);

        self::assertEquals($typeExpected, $createTag->type);
        self::assertEquals($nameExpected, $createTag->name);
    }

    public function testCreateTagWithInvalidName(): void
    {
        $this->expectException(InvalidArgumentsException::class);
        new CreateTag(type: 'foo', name: 'F0O!');
    }
}
