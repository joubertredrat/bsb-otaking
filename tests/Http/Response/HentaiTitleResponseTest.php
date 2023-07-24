<?php

declare(strict_types=1);

namespace App\Tests\Http\Response;

use App\Entity\Fansub;
use App\Entity\HentaiFile;
use App\Entity\HentaiTitle;
use App\Entity\Tag;
use App\Entity\VideoFile;
use App\Http\Response\HentaiTitleResponse;
use App\Tests\Helper;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class HentaiTitleResponseTest extends TestCase
{
    public function testJsonSerialize(): void
    {
        $fansubFoo = (new Fansub())->setName('Fansub Foo');
        $tagFoo = (new Tag())
            ->setType(Tag::TYPE_ALL)
            ->setName('foo')
        ;
        $videoFileOne = (new VideoFile())->setName(Helper::VIDEOFILE_01);
        $videoFileTwo = (new VideoFile())->setName(Helper::VIDEOFILE_02);

        $arrayExpected = [
            'id' => null,
            'name' => 'Title Foo',
            'alternativeNames' => ['ほげ'],
            'type' => HentaiTitle::TYPE_2D,
            'language' => HentaiTitle::LANGUAGE_PT_BR,
            'episodes' => 2,
            'statusDownload' => HentaiTitle::STATUS_DOWNLOAD_COMPLETE,
            'statusView' => HentaiTitle::STATUS_VIEW_DONE,
            'fansubs' => [
                [
                    'id' => $fansubFoo->getId(),
                    'name' => $fansubFoo->getName(),
                ],
            ],
            'tags' => [
                [
                    'id' => $tagFoo->getId(),
                    'resourceName' => $tagFoo->getResourceName(),
                ],
            ],
            'videoFiles' => [
                $videoFileOne->getName(),
                $videoFileTwo->getName(),
            ],
            'createdAt' => '2023-06-29 19:18:17',
            'updatedAt' => null,
        ];

        $hentaiTitle = (new HentaiTitle())
            ->setName('Title Foo')
            ->setAlternativeNames(['ほげ'])
            ->setType(HentaiTitle::TYPE_2D)
            ->setLanguage(HentaiTitle::LANGUAGE_PT_BR)
            ->setEpisodes(2)
            ->setStatusDownload(HentaiTitle::STATUS_DOWNLOAD_COMPLETE)
            ->setStatusView(HentaiTitle::STATUS_VIEW_DONE)
            ->addFansub($fansubFoo)
            ->addTag($tagFoo)
            ->addVideoFile($videoFileOne)
            ->addVideoFile($videoFileTwo)
            ->setCreatedAt(new DateTimeImmutable('2023-06-29 19:18:17'))
        ;
        $response = new HentaiTitleResponse($hentaiTitle);

        self::assertEquals($arrayExpected, $response->jsonSerialize());
    }
}
