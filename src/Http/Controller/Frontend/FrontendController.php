<?php

declare(strict_types=1);

namespace App\Http\Controller\Frontend;

use Fig\Http\Message\RequestMethodInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontendController extends AbstractController
{
    #[Route(
        path: '/',
        name: 'app_frontend_index',
        methods: [RequestMethodInterface::METHOD_GET],
    )]
    public function index(): Response
    {
        return $this->render('index.html.twig', [
            'title' => 'Not today :)',
        ]);
    }

    #[Route(
        path: '/pato/fansub',
        name: 'app_frontend_fansub',
        methods: [RequestMethodInterface::METHOD_GET],
    )]
    public function page(): Response
    {
        return $this->render('fansub.html.twig');
    }
}
