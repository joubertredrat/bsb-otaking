<?php

declare(strict_types=1);

namespace App\Tests\Unit\Dto;

use App\Dto\HentaiTitleTrait;
use App\Tests\Helper;
use PHPUnit\Framework\TestCase;

class HentaiTitleTraitTest extends TestCase
{
    public function testHentaiTitleTrait(): void
    {
        $class = new class() {
            use HentaiTitleTrait;
        };

        self::assertTrue($class::isValidId(10));
        self::assertTrue($class::isValidIds([10]));
        self::assertTrue($class::isValidVideoFiles([Helper::VIDEOFILE_01]));

        self::assertFalse($class::isValidId(0));
        self::assertFalse($class::isValidIds([0]));
        self::assertFalse($class::isValidVideoFiles(['foo']));
    }
}
