<?php

declare(strict_types=1);

namespace App\Tests\Unit\UseCase;

use App\Dto\ListFansubs as DtoListFansubs;
use App\Dto\Pagination;
use App\Entity\Fansub;
use App\Repository\FansubRepositoryInterface;
use App\UseCase\ListFansubs;
use Mockery;
use PHPUnit\Framework\TestCase;

class ListFansubsTest extends TestCase
{
    public function testListTagsWithSuccess(): void
    {
        $dtoListFansubs = new DtoListFansubs(new Pagination(1, 10), '');

        $fansubFoo = (new Fansub())->setName('Foo');
        $fansubBar = (new Fansub())->setName('Bar');

        $fansubsExpected = [$fansubFoo, $fansubBar];
        $totalExpected = 2;

        $fansubRepository = Mockery::mock(FansubRepositoryInterface::class);
        $fansubRepository
            ->shouldReceive('list')
            ->andReturn($fansubsExpected)
        ;
        $fansubRepository
            ->shouldReceive('countAll')
            ->andReturn($totalExpected)
        ;

        /** @var FansubRepositoryInterface $fansubRepository */
        $listFansubs = new ListFansubs($fansubRepository);
        $fansubsGot = $listFansubs->execute($dtoListFansubs);

        self::assertEquals($fansubsExpected, $fansubsGot->items);
        self::assertEquals($totalExpected, $fansubsGot->total->value);
    }
}
