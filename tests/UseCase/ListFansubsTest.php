<?php

declare(strict_types=1);

namespace App\Tests\UseCase;

use App\Entity\Fansub;
use App\Repository\FansubRepositoryInterface;
use App\UseCase\ListFansubs;
use PHPUnit\Framework\TestCase;

class ListFansubsTest extends TestCase
{
    public function testListTagsWithSuccess(): void
    {
        $fansubFoo = new Fansub();
        $fansubFoo->setName('Foo');
        $fansubBar = new Fansub();
        $fansubBar->setName('Bar');

        $fansubsExpected = [$fansubFoo, $fansubBar];

        $fansubRepository = \Mockery::mock(FansubRepositoryInterface::class);
        $fansubRepository
            ->shouldReceive('list')
            ->andReturn($fansubsExpected)
        ;

        $listFansubs = new ListFansubs($fansubRepository);
        $fansubsGot = $listFansubs->execute();

        self::assertEquals($fansubsExpected, $fansubsGot);
    }
}
