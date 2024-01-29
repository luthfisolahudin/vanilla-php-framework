<?php

declare(strict_types=1);

namespace Sys\Http\Request;

use Sys\Http\Auth\AuthInterface;
use Sys\Http\Router\RouterInterface;
use Sys\Http\Session\SessionInterface;
use Sys\Http\Status;

class Request implements RequestInterface
{
    public function __construct(
        protected AuthInterface $auth,
        protected SessionInterface $session,
        protected RouterInterface $router,
    ) {}

    public function get(string $key, mixed $default = null): mixed
    {
        return $_GET[$key] ?? $_POST[$key] ?? $default;
    }

    public function auth(): AuthInterface
    {
        return $this->auth;
    }

    public function isAuthenticated(): bool
    {
        return null !== $this->auth()->user();
    }

    public function session(): SessionInterface
    {
        return $this->session;
    }

    public function abort(int $code = Status::NOT_FOUND): void
    {
        $this->router->abort($code);
    }
}
