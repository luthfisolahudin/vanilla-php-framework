<?php

declare(strict_types=1);

namespace Sys\Http\Middleware;

use Sys\Http\Request\RequestInterface;

class AuthenticatedMiddleware implements MiddlewareInterface
{
    public function __invoke(RequestInterface $request): bool
    {
        return $request->isAuthenticated();
    }
}
