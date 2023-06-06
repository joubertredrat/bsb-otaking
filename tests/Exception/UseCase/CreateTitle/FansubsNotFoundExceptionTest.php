<?php

declare(strict_types=1);

namespace App\Tests\Exception\UseCase\CreateTitle;

use App\Exception\UseCase\CreateTitle\FansubsNotFoundException;
use PHPUnit\Framework\TestCase;

class FansubsNotFoundExceptionTest extends TestCase
{
    public function testThrowException(): void
    {
        $this->expectException(FansubsNotFoundException::class);
        $this->expectExceptionMessage('Fansubs with IDs not found: 1, 2');

        throw FansubsNotFoundException::dispatch([1, 2]);
    }
}
