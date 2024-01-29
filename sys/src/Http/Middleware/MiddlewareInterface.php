<?php

declare(strict_types=1);

namespace Sys\Http\Middleware;

use Sys\Http\Request\RequestInterface;

interface MiddlewareInterface
{
    public function __invoke(RequestInterface $request): bool|int;
}
