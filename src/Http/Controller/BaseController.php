<?php

declare(strict_types=1);

namespace App\Http\Controller;

use Fig\Http\Message\RequestMethodInterface as RequestMethod;
use Fig\Http\Message\StatusCodeInterface as StatusCode;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class BaseController extends AbstractController
{
    public const METHOD_GET = RequestMethod::METHOD_GET;
    public const METHOD_POST = RequestMethod::METHOD_POST;
    public const METHOD_PUT = RequestMethod::METHOD_PUT;
    public const STATUS_OK = StatusCode::STATUS_OK;
    public const STATUS_CREATED = StatusCode::STATUS_CREATED;
}
