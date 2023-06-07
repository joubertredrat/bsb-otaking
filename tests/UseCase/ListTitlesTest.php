<?php

declare(strict_types=1);

namespace App\Tests\UseCase;

use App\Entity\Title;
use App\Repository\TitleRepositoryInterface;
use App\UseCase\ListTitles;
use PHPUnit\Framework\TestCase;

class ListTitlesTest extends TestCase
{
    public function testListTitlesWithSuccess(): void
    {
        $titleFoo = new Title();
        $titleFoo->setName('Super Foo');
        $titleBar = new Title();
        $titleBar->setName('Extreme Bar');

        $titlesExpected = [$titleFoo, $titleBar];

        $titleRepository = \Mockery::mock(TitleRepositoryInterface::class);
        $titleRepository
            ->shouldReceive('list')
            ->andReturn($titlesExpected)
        ;

        $listTitles = new ListTitles($titleRepository);
        $titlesGot = $listTitles->execute();

        self::assertEquals($titlesExpected, $titlesGot);
    }
}
