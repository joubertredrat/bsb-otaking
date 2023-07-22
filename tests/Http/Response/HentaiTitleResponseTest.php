<?php

declare(strict_types=1);

namespace App\Tests\Http\Response;

use App\Entity\Fansub;
use App\Entity\HentaiFile;
use App\Entity\HentaiTitle;
use App\Entity\Tag;
use App\Http\Response\HentaiTitleResponse;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class HentaiTitleResponseTest extends TestCase
{
    public function testJsonSerialize(): void
    {
        $arrayExpected = [
            'id' => null,
            'name' => 'Title Foo',
            'alternativeNames' => ['ほげ'],
            'type' => '2D',
            'language' => 'pt_br',
            'episodes' => 2,
            'statusDownload' => 'complete',
            'statusView' => 'done',
            'fansubs' => [
                [
                    'id' => null,
                    'name' => 'Fansub Foo',
                ],
            ],
            'tags' => [sprintf('%s:foo', Tag::TYPE_ALL)],
            'files' => [
                'EP01.mkv',
                'EP02.mkv',
            ],
            'createdAt' => '2023-06-29 19:18:17',
            'updatedAt' => null,
        ];

        $hentaiTitle = new HentaiTitle();
        $hentaiTitle->setName('Title Foo');
        $hentaiTitle->setAlternativeNames(['ほげ']);
        $hentaiTitle->setType('2D');
        $hentaiTitle->setLanguage('pt_br');
        $hentaiTitle->setEpisodes(2);
        $hentaiTitle->setStatusDownload('complete');
        $hentaiTitle->setStatusView('done');
        $hentaiTitle->setCreatedAt(new DateTimeImmutable('2023-06-29 19:18:17'));

        $fansubFoo = new Fansub();
        $fansubFoo->setName('Fansub Foo');
        $hentaiTitle->addFansub($fansubFoo);

        $tagFoo = new Tag();
        $tagFoo->setType(Tag::TYPE_ALL);
        $tagFoo->setName('foo');
        $hentaiTitle->addTag($tagFoo);

        $hentaiFileOne = new HentaiFile();
        $hentaiFileOne->setName('EP01.mkv');
        $hentaiFileTwo = new HentaiFile();
        $hentaiFileTwo->setName('EP02.mkv');
        $hentaiTitle->addFile($hentaiFileOne);
        $hentaiTitle->addFile($hentaiFileTwo);

        $response = new HentaiTitleResponse($hentaiTitle);

        self::assertEquals($arrayExpected, $response->jsonSerialize());
    }
}
