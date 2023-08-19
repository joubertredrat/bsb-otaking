<?php

declare(strict_types=1);

namespace App\Tests\Unit\Exception\Entity\HentaiTitle;

use App\Exception\Entity\HentaiTitle\InvalidEpisodesException;
use PHPUnit\Framework\TestCase;

class InvalidEpisodesExceptionTest extends TestCase
{
    public function testThrowException(): void
    {
        $this->expectException(InvalidEpisodesException::class);
        $this->expectExceptionMessage('Invalid episodes got [ 2 ]');

        throw InvalidEpisodesException::create(2);
    }
}
