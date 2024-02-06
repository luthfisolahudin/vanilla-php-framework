<?php

declare(strict_types=1);

namespace Sys\Http\Request;

use Sys\Http\Auth\AuthInterface;
use Sys\Http\Router\RouterInterface;
use Sys\Http\Session\SessionInterface;
use Sys\Http\Status;
use Sys\Support\Csrf;

class Request implements RequestInterface
{
    protected string $method;

    protected string $uri;

    public function __construct(
        protected SessionInterface $session,
        protected RouterInterface $router,
        ?string $method = null,
        ?string $uri = null,
    ) {
        $this->method = $method ?? static::getMethod();
        $this->uri = $uri ?? static::getUri();
    }

    public function method(): string
    {
        return $this->method;
    }

    public function uri(): string
    {
        return $this->uri;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return sanitize($_GET[$key] ?? $_POST[$key] ?? $default);
    }

    public function token(): ?string
    {
        return sanitize($this->get(Csrf::name()));
    }

    public function auth(): AuthInterface
    {
        return container()->get(AuthInterface::class);
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

    public static function getMethod(): string
    {
        return $_POST[static::METHOD_OVERRIDE] ?? $_SERVER['REQUEST_METHOD'];
    }

    public static function getUri(): string
    {
        return parse_url($_SERVER['REQUEST_URI'])['path'];
    }
}
