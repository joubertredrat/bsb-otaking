<?php

declare(strict_types=1);

namespace App\Tests\Exception\UseCase\EditHentaiTitle;

use App\Exception\UseCase\EditHentaiTitle\FansubsNotFoundException;
use PHPUnit\Framework\TestCase;

class FansubsNotFoundExceptionTest extends TestCase
{
    public function testThrowException(): void
    {
        $this->expectException(FansubsNotFoundException::class);
        $this->expectExceptionMessage('Fansubs with IDs not found: 1, 2');

        throw FansubsNotFoundException::create([1, 2]);
    }
}
