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
    public function pageIndex(): Response
    {
        return $this->render('index.html.twig');
    }

    #[Route(
        path: '/pato',
        name: 'app_frontend_pato',
        methods: [RequestMethodInterface::METHOD_GET],
    )]
    public function pagePato(): Response
    {
        return $this->render('pato.html.twig');
    }

    #[Route(
        path: '/pato/fansub',
        name: 'app_frontend_fansub',
        methods: [RequestMethodInterface::METHOD_GET],
    )]
    public function pageFansub(): Response
    {
        return $this->render('fansub.html.twig');
    }

    #[Route(
        path: '/pato/tag',
        name: 'app_frontend_tag',
        methods: [RequestMethodInterface::METHOD_GET],
    )]
    public function pageTag(): Response
    {
        return $this->render('tag.html.twig');
    }

    #[Route(
        path: '/pato/hentai-title',
        name: 'app_frontend_hentai_title',
        methods: [RequestMethodInterface::METHOD_GET],
    )]
    public function pageHentaiTitle(): Response
    {
        return $this->render('hentai_title.html.twig');
    }
}
