<?php

declare(strict_types=1);

namespace App\Tests\Unit\Dto;

use App\Dto\CreateFansub;
use App\Exception\Dto\CreateFansub\InvalidNameException;
use PHPUnit\Framework\TestCase;

class CreateFansubTest extends TestCase
{
    public function testCreateFansub(): void
    {
        $nameExpected = 'Fansub';
        $createFansub = new CreateFansub(name: $nameExpected);

        self::assertEquals($nameExpected, $createFansub->name);
    }

    public function testCreateTagWithInvalidName(): void
    {
        $this->expectException(InvalidNameException::class);
        new CreateFansub(name: '');
    }
}
