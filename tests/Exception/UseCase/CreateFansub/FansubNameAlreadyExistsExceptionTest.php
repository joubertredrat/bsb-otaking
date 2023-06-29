<?php

declare(strict_types=1);

namespace App\Tests\Exception\UseCase\CreateFansub;

use App\Exception\UseCase\CreateFansub\FansubNameAlreadyExistsException;
use PHPUnit\Framework\TestCase;

class FansubNameAlreadyExistsExceptionTest extends TestCase
{
    public function testThrowException(): void
    {
        $this->expectException(FansubNameAlreadyExistsException::class);
        $this->expectExceptionMessage('Fansub with name foo already exists');

        throw FansubNameAlreadyExistsException::dispatch('foo');
    }
}
