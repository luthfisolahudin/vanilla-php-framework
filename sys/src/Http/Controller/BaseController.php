<?php

declare(strict_types=1);

namespace Sys\Http\Controller;

use Sys\Http\Request\RequestInterface;

abstract class BaseController implements ControllerInterface
{
    public function __construct(
        protected RequestInterface $request,
    ) {}

    public function request(): RequestInterface
    {
        return $this->request;
    }
}
