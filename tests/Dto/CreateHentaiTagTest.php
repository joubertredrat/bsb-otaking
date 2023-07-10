<?php

declare(strict_types=1);

namespace App\Tests\Dto;

use App\Dto\CreateHentaiTag;
use App\Exception\Dto\CreateHentaiTag\InvalidNameException;
use PHPUnit\Framework\TestCase;

class CreateHentaiTagTest extends TestCase
{
    public function testCreateHentaiTag(): void
    {
        $nameExpected = 'foo:bar';
        $createHentaiTag = new CreateHentaiTag(name: $nameExpected);

        self::assertEquals($nameExpected, $createHentaiTag->name);
    }

    public function testCreateHentaiTagWithInvalidName(): void
    {
        $this->expectException(InvalidNameException::class);
        new CreateHentaiTag(name: 'foo-bar');
    }
}
