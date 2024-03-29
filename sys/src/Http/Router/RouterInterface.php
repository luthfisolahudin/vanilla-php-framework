<?php

declare(strict_types=1);

namespace Sys\Http\Router;

use Sys\Http\Request\RequestInterface;
use Sys\Http\Status;

interface RouterInterface
{
    public function add(string $method, string $uri, string $controller, array $middlewares = []): static;

    public function get(string $uri, string $controller, array $middlewares = []): static;

    public function post(string $uri, string $controller, array $middlewares = []): static;

    public function delete(string $uri, string $controller, array $middlewares = []): static;

    public function patch(string $uri, string $controller, array $middlewares = []): static;

    public function put(string $uri, string $controller, array $middlewares = []): static;

    public function has(string $uri, ?string $method = null): bool;

    public function handle(RequestInterface $request): void;

    public function redirect(string $path, int $code = Status::FOUND): void;

    public function abort(int $code = Status::NOT_FOUND): void;
}
