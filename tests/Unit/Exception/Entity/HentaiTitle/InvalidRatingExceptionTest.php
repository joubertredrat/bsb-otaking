<?php

declare(strict_types=1);

namespace App\Tests\Unit\Exception\Entity\HentaiTitle;

use App\Exception\Entity\HentaiTitle\InvalidRatingException;
use PHPUnit\Framework\TestCase;

class InvalidRatingExceptionTest extends TestCase
{
    public function testThrowException(): void
    {
        $this->expectException(InvalidRatingException::class);
        $this->expectExceptionMessage('Invalid rating got [ 7 ], expected between [ 0 ] and [ 5 ]');

        throw InvalidRatingException::create(7, 0, 5);
    }
}
