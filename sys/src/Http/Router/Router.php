<?php

declare(strict_types=1);

namespace Sys\Http\Router;

use Sys\App;
use Sys\Config\ConfigInterface;
use Sys\Http\Controller\ErrorController;
use Sys\Http\Request\Method;
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

    public function has(string $uri, string $method): bool
    {
        return isset($this->routes[$uri][$method]);
    }

    /**
     * @throws MiddlewareException
     */
    public function handle(string $uri, string $method): void
    {
        if (! $this->has($uri, $method)) {
            $this->abort();

            return;
        }

        $route = $this->routes[$uri][$method];
        $controller = App::container()->get($route['controller']);

        foreach ($route['middlewares'] as $middleware) {
            $pass = App::container()->get($middleware)($controller->request());

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

    public function abort(int $code = Status::NOT_FOUND): void
    {
        http_response_code($code);

        echo App::container()->get($this->abortController($code))();

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
