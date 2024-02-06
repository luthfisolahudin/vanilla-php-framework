<?php

declare(strict_types=1);

namespace Sys\Http\Middleware;

use Sys\Config\ConfigInterface;
use Sys\Http\Request\RequestInterface;

class AuthenticatedMiddleware implements MiddlewareInterface
{
    public function __construct(
        protected ConfigInterface $config,
    ) {}

    public function __invoke(RequestInterface $request): bool
    {
        if ($request->isAuthenticated()) {
            return true;
        }

        $request->redirect($this->config->get('middleware.auth.redirect', '/'));

        return false;
    }
}
