<?php

declare(strict_types=1);

namespace App\Tests\Exception\UseCase\CreateHentaiTag;

use App\Exception\UseCase\CreateHentaiTag\HentaiTagNameAlreadyExistsException;
use PHPUnit\Framework\TestCase;

class HentaiTagNameAlreadyExistsExceptionTest extends TestCase
{
    public function testThrowException(): void
    {
        $this->expectException(HentaiTagNameAlreadyExistsException::class);
        $this->expectExceptionMessage('Hentai Tag with name foo already exists');

        throw HentaiTagNameAlreadyExistsException::dispatch('foo');
    }
}
