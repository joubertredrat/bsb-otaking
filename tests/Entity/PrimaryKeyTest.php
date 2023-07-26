<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\PrimaryKey;
use App\Exception\Entity\PrimaryKeyable\InvalidPrimaryKeyException;
use PHPUnit\Framework\TestCase;

class PrimaryKeyTest extends TestCase
{
    public function testAttributes(): void
    {
        $idExpected = 10;
        $foo = new class {
            use PrimaryKey;
        };

        self::assertNull($foo->getId());
        $foo->setId($idExpected);
        self::assertEquals($idExpected, $foo->getId());
    }

    public function testAttributesWithInvalidPrimaryKeyException(): void
    {
        $this->expectException(InvalidPrimaryKeyException::class);

        $foo = new class {
            use PrimaryKey;
        };
        $foo->setId(-10);
    }
}
