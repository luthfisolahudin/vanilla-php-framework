<?php

declare(strict_types=1);

namespace Sys\Http\Controller;

use Sys\Http\Request\RequestInterface;

interface ControllerInterface
{
    public function request(): RequestInterface;

    public function __invoke();
}
