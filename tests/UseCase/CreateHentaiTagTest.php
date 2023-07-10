<?php

declare(strict_types=1);

namespace App\Tests\UseCase;

use App\Dto\CreateHentaiTag as DtoCreateHentaiTag;
use App\Entity\HentaiTag;
use App\Exception\UseCase\CreateHentaiTag\HentaiTagNameAlreadyExistsException;
use App\Repository\HentaiTagRepositoryInterface;
use App\UseCase\CreateHentaiTag;
use Mockery;
use PHPUnit\Framework\TestCase;

class CreateHentaiTagTest extends TestCase
{
    public function testCreateHentaiTagWithSuccess(): void
    {
        $dtoCreateHentaiTag = new DtoCreateHentaiTag(name: 'foo:bar');

        $hentaiTagRepository = Mockery::mock(HentaiTagRepositoryInterface::class);
        $hentaiTagRepository
            ->shouldReceive('getByName')
            ->withArgs(['foo:bar'])
            ->andReturn(null)
        ;
        $hentaiTagRepository
            ->shouldReceive('save')
            ->once()
        ;

        $usecase = new CreateHentaiTag($hentaiTagRepository);
        $hentaiTagGot = $usecase->execute($dtoCreateHentaiTag);

        self::assertEquals($dtoCreateHentaiTag->name, $hentaiTagGot->getName());
    }

    public function testCreateHentaiTagWithNameAlreadyExists(): void
    {
        $this->expectException(HentaiTagNameAlreadyExistsException::class);

        $dtoCreateHentaiTag = new DtoCreateHentaiTag(name: 'foo:bar');
        $hentaiTagFound = new HentaiTag();
        $hentaiTagFound->setName('foo:bar');

        $hentaiTagRepository = Mockery::mock(HentaiTagRepositoryInterface::class);
        $hentaiTagRepository
            ->shouldReceive('getByName')
            ->withArgs(['foo:bar'])
            ->andReturn($hentaiTagFound)
        ;

        $usecase = new CreateHentaiTag($hentaiTagRepository);
        $usecase->execute($dtoCreateHentaiTag);
    }
}
