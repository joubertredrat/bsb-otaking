<?php

declare(strict_types=1);

namespace App\Tests\Unit\Http\Controller\Api;

use App\Dto\CreateFansub as DtoCreateFansub;
use App\Entity\Fansub;
use App\Http\Controller\Api\FansubsController;
use App\Http\Request\CreateFansubRequest;
use App\Tests\Helper;
use App\Tests\Unit\Http\Controller\ControllerTestCase;
use App\UseCase\CreateFansub;
use App\UseCase\ListFansubs;
use App\ValueObject\PaginatedItems;
use App\ValueObject\Total;
use Mockery;

class FansubsControllerTest extends ControllerTestCase
{
    public function testList(): void
    {
        $container = $this->getContainerMock();

        $createFansub = Mockery::mock(CreateFansub::class);

        $fansubFoo = (new Fansub())->setName('Foo')->setCreatedAtNow();
        $fansubBar = (new Fansub())->setName('Bar')->setCreatedAtNow();
        $listFansubs = Mockery::mock(ListFansubs::class);
        $listFansubs
            ->shouldReceive('execute')
            ->andReturn(new PaginatedItems([$fansubFoo, $fansubBar], new Total(2)))
        ;

        /** @var CreateFansub $createFansub */
        /** @var ListFansubs $listFansubs */
        $controller = new FansubsController(
            createFansub: $createFansub,
            listFansubs: $listFansubs,
        );
        $controller->setContainer($container);

        $request = Helper::getRequestMock(queryData: ['page' => 1, 'itemsPerPage' => 10]);

        $response = $controller->list($request);
        self::assertEqualStatusOk($response->getStatusCode());
    }

    public function testCreate(): void
    {
        $container = $this->getContainerMock();

        $fansubFoo = (new Fansub())->setName('Foo')->setCreatedAtNow();

        $createFansub = Mockery::mock(CreateFansub::class);
        $createFansub
            ->shouldReceive('execute')
            ->with(Mockery::on(function ($argument) {
                return $argument instanceof DtoCreateFansub;
            }))
            ->andReturn($fansubFoo)
        ;
        $listFansubs = Mockery::mock(ListFansubs::class);

        /** @var CreateFansub $createFansub */
        /** @var ListFansubs $listFansubs */
        $controller = new FansubsController(
            createFansub: $createFansub,
            listFansubs: $listFansubs,
        );
        $controller->setContainer($container);

        $validator = Helper::getValidationMock();
        $request = Helper::getRequestMock(bodyData: ['name' => 'Foo Fansub']);
        $requestStack = Helper::getRequestStackMock($request);
        $createFansubRequest = new CreateFansubRequest(
            validator: $validator,
            requestStack: $requestStack,
            convertCase: false,
        );

        $response = $controller->create($createFansubRequest);
        self::assertEqualStatusCreated($response->getStatusCode());
    }
}
