<?php

declare(strict_types=1);

namespace App\Tests\Exception\UseCase\GetHentaiTitle;

use App\Exception\UseCase\GetHentaiTitle\HentaiTitleNotFoundException;
use PHPUnit\Framework\TestCase;

class HentaiTitleNotFoundExceptionTest extends TestCase
{
    public function testThrowException(): void
    {
        $this->expectException(HentaiTitleNotFoundException::class);
        $this->expectExceptionMessage('Hentai title not found by id [ 10 ]');

        throw HentaiTitleNotFoundException::create(10);
    }
}
