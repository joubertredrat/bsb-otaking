<?php

declare(strict_types=1);

namespace App\Tests\Http\Controller\Api;

use App\Dto\CreateFansub as DtoCreateFansub;
use App\Entity\Fansub;
use App\Http\Controller\Api\FansubsController;
use App\Http\Request\CreateFansubRequest;
use App\Tests\Helper;
use App\UseCase\CreateFansub;
use App\UseCase\ListFansubs;
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
            ->andReturn([$fansubFoo, $fansubBar])
        ;

        $controller = new FansubsController(
            createFansub: $createFansub,
            listFansubs: $listFansubs,
        );
        $controller->setContainer($container);

        $response = $controller->list();
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

        $controller = new FansubsController(
            createFansub: $createFansub,
            listFansubs: $listFansubs,
        );
        $controller->setContainer($container);

        $validator = Helper::getValidationMock();
        $request = Helper::getRequestMock(['name' => 'Foo Fansub']);
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
