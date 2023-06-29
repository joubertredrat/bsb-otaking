<?php

declare(strict_types=1);

namespace App\Tests\UseCase;

use App\Dto\CreateFansub as DtoCreateFansub;
use App\Entity\Fansub;
use App\Exception\Dto\CreateFansub\InvalidNameException;
use App\Repository\FansubRepositoryInterface;
use App\UseCase\CreateFansub;
use Mockery;
use PHPUnit\Framework\TestCase;

class CreateFansubTest extends TestCase
{
    public function testCreateFansubWithSuccess(): void
    {
        $dtoCreateTag = new DtoCreateFansub(name: 'Foo');

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

        $createTag = new CreateFansub($fansubRepository);
        $fansubGot = $createTag->execute($dtoCreateTag);

        self::assertEquals($dtoCreateTag->name, $fansubGot->getName());
    }

    public function testCreateFansubWithNameAlreadyExists(): void
    {
        $this->expectException(InvalidNameException::class);

        $dtoCreateTag = new DtoCreateFansub(name: 'Foo');
        $fansubFound = new Fansub();
        $fansubFound->setName('Foo');

        $fansubRepository = Mockery::mock(FansubRepositoryInterface::class);
        $fansubRepository
            ->shouldReceive('getByName')
            ->withArgs(['Foo'])
            ->andReturn($fansubFound)
        ;

        $createTag = new CreateFansub($fansubRepository);
        $createTag->execute($dtoCreateTag);
    }
}
