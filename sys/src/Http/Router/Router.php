<?php

declare(strict_types=1);

namespace Sys\Http\Router;

use Sys\Config\ConfigInterface;
use Sys\Http\Controller\ErrorController;
use Sys\Http\Request\Method;
use Sys\Http\Request\RequestInterface;
use Sys\Http\Router\Exception\MiddlewareException;
use Sys\Http\Status;

class Router implements RouterInterface
{
    protected array $routes = [];

    public function __construct(
        protected ConfigInterface $config,
    ) {}

    public function add(string $method, string $uri, string $controller, array $middlewares = []): static
    {
        $uri = '/'.trim($uri, '/');

        $this->routes[$uri][$method] = [
            'middlewares' => $middlewares,
            'controller' => $controller,
        ];

        return $this;
    }

    public function get(string $uri, string $controller, array $middlewares = []): static
    {
        return $this->add(Method::GET, $uri, $controller, $middlewares);
    }

    public function post(string $uri, string $controller, array $middlewares = []): static
    {
        return $this->add(Method::POST, $uri, $controller, $middlewares);
    }

    public function delete(string $uri, string $controller, array $middlewares = []): static
    {
        return $this->add(Method::DELETE, $uri, $controller, $middlewares);
    }

    public function patch(string $uri, string $controller, array $middlewares = []): static
    {
        return $this->add(Method::PATCH, $uri, $controller, $middlewares);
    }

    public function put(string $uri, string $controller, array $middlewares = []): static
    {
        return $this->add(Method::PUT, $uri, $controller, $middlewares);
    }

    public function has(string $uri, ?string $method = null): bool
    {
        if (null === $method) {
            return \array_key_exists($uri, $this->routes);
        }

        return isset($this->routes[$uri][$method]);
    }

    /**
     * @throws MiddlewareException
     */
    public function handle(RequestInterface $request): void
    {
        if (! $this->has($request->uri())) {
            $this->abort();

            return;
        }

        if (! $this->has($request->uri(), $request->method())) {
            $this->abort(Status::METHOD_NOT_ALLOWED);

            return;
        }

        $route = $this->routes[$request->uri()][$request->method()];
        $controller = container()->get($route['controller']);
        $middlewares = [...$this->config->get('middlewares'), ...$route['middlewares']];

        foreach ($middlewares as $middleware) {
            $pass = container()->get($middleware)($request);

            if (true === $pass) {
                continue;
            } elseif (false === $pass) {
                $pass = Status::FORBIDDEN;
            } elseif (! \is_int($pass)) {
                throw new MiddlewareException("Unrecognized middleware response: {$pass}");
            }

            $this->abort($pass);

            return;
        }

        echo $controller();
    }

    public function redirect(string $path, int $code = Status::FOUND): void
    {
        http_response_code($code);
        header("Location: {$path}");

        exit();
    }

    public function abort(int $code = Status::NOT_FOUND): void
    {
        http_response_code($code);

        echo container()->get($this->abortController($code))();

        exit();
    }

    protected function abortController(int $code): string
    {
        if ($controller = $this->config->get("errors.{$code}")) {
            return $controller;
        }

        if ($controller = $this->config->get('errors.any')) {
            return $controller;
        }

        return ErrorController::class;
    }
}
