<?php

declare(strict_types=1);

namespace App\Tests\UseCase;

use App\Entity\HentaiTag;
use App\Repository\HentaiTagRepositoryInterface;
use App\UseCase\ListHentaiTags;
use Mockery;
use PHPUnit\Framework\TestCase;

class ListHentaiTagsTest extends TestCase
{
    public function testListHentaiTagsWithSuccess(): void
    {
        $tagHentaiFoo = new HentaiTag();
        $tagHentaiFoo->setName('tag:foo');
        $tagHentaiBar = new HentaiTag();
        $tagHentaiBar->setName('tag:bar');

        $tagsHentaiExpected = [$tagHentaiFoo, $tagHentaiBar];

        $tagRepository = Mockery::mock(HentaiTagRepositoryInterface::class);
        $tagRepository
            ->shouldReceive('list')
            ->andReturn($tagsHentaiExpected)
        ;

        $usecase = new ListHentaiTags($tagRepository);
        $hentaiTagsGot = $usecase->execute();

        self::assertEquals($tagsHentaiExpected, $hentaiTagsGot);
    }
}
