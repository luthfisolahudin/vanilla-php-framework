<?php

declare(strict_types=1);

namespace Sys\Http\Middleware;

use Sys\Http\Request\Method;
use Sys\Http\Request\RequestInterface;
use Sys\Http\Session\SessionInterface;

class CsrfMiddleware implements MiddlewareInterface
{
    public function __construct(
        protected SessionInterface $session,
    ) {}

    public function __invoke(RequestInterface $request): bool
    {
        if (Method::GET === $request->method()) {
            return true;
        }

        return null !== $request->token()
            && $this->session->token() === $request->token();
    }
}
