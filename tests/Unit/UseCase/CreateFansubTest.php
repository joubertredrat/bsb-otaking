<?php

declare(strict_types=1);

namespace App\Tests\Unit\UseCase;

use App\Dto\CreateFansub as DtoCreateFansub;
use App\Entity\Fansub;
use App\Exception\UseCase\CreateFansub\FansubNameAlreadyExistsException;
use App\Repository\FansubRepositoryInterface;
use App\UseCase\CreateFansub;
use Mockery;
use PHPUnit\Framework\TestCase;

class CreateFansubTest extends TestCase
{
    public function testCreateFansubWithSuccess(): void
    {
        $dtoCreateFansub = new DtoCreateFansub(name: 'Foo');

        $fansubRepository = Mockery::mock(FansubRepositoryInterface::class);
        $fansubRepository
            ->shouldReceive('getByName')
            ->withArgs(['Foo'])
            ->andReturn(null)
        ;
        $fansubRepository
            ->shouldReceive('save')
            ->once()
        ;

        /** @var FansubRepositoryInterface $fansubRepository */
        $createFansub = new CreateFansub($fansubRepository);
        $fansubGot = $createFansub->execute($dtoCreateFansub);

        self::assertEquals($dtoCreateFansub->name, $fansubGot->getName());
    }

    public function testCreateFansubWithNameAlreadyExists(): void
    {
        $this->expectException(FansubNameAlreadyExistsException::class);

        $dtoCreateFansub = new DtoCreateFansub(name: 'Foo');
        $fansubFound = new Fansub();
        $fansubFound->setName('Foo');

        $fansubRepository = Mockery::mock(FansubRepositoryInterface::class);
        $fansubRepository
            ->shouldReceive('getByName')
            ->withArgs(['Foo'])
            ->andReturn($fansubFound)
        ;

        /** @var FansubRepositoryInterface $fansubRepository */
        $createFansub = new CreateFansub($fansubRepository);
        $createFansub->execute($dtoCreateFansub);
    }
}
