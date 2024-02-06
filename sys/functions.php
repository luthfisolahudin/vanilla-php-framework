<?php

declare(strict_types=1);

use Sys\App;
use Sys\Config\ConfigInterface;
use Sys\Container\ContainerInterface;
use Sys\Http\Request\RequestInterface;
use Sys\Http\Router\RouterInterface;
use Sys\Http\Session\SessionInterface;
use Sys\Support\Arr;
use Sys\Support\Csrf;
use Sys\View\ViewInterface;

if (! \function_exists('base_path')) {
    function base_path(?string $path = null): string
    {
        if (null === $path) {
            return BASE_PATH;
        }

        return BASE_PATH."/{$path}";
    }
}

if (! \function_exists('app_path')) {
    function app_path(?string $path = null): string
    {
        if (null === $path) {
            return base_path('app');
        }

        return base_path('app')."/{$path}";
    }
}

if (! \function_exists('container')) {
    function container(): ContainerInterface
    {
        return App::container();
    }
}

if (! \function_exists('config')) {
    function config(): ConfigInterface
    {
        return container()->get(ConfigInterface::class);
    }
}

if (! \function_exists('session')) {
    function session(): SessionInterface
    {
        return container()->get(SessionInterface::class);
    }
}

if (! \function_exists('router')) {
    function router(): RouterInterface
    {
        return container()->get(RouterInterface::class);
    }
}

if (! \function_exists('request')) {
    function request(): RequestInterface
    {
        return container()->get(RequestInterface::class);
    }
}

if (! \function_exists('view')) {
    function view(): ViewInterface
    {
        return container()->get(ViewInterface::class);
    }
}

if (! \function_exists('e')) {
    /**
     * @see https://securinglaravel.com/p/security-tip-escape-output-with-e
     * @see https://github.com/laravel/framework/blob/10.x/src/Illuminate/Support/helpers.php#L102-L126
     */
    function e(mixed $value, bool $doubleEncode = true): string
    {
        return htmlspecialchars((string) $value, \ENT_QUOTES | \ENT_SUBSTITUTE, 'UTF-8', $doubleEncode);
    }
}

if (! \function_exists('sanitize')) {
    function sanitize(mixed $value): mixed
    {
        if (! \is_string($value)) {
            return $value;
        }

        if ('' === $sanitized = trim(filter_var($value, \FILTER_SANITIZE_STRING))) {
            return null;
        }

        if (null !== $value = filter_var($sanitized, \FILTER_VALIDATE_INT, \FILTER_NULL_ON_FAILURE)) {
            return $value;
        }

        if (null !== $value = filter_var($sanitized, \FILTER_VALIDATE_BOOLEAN, \FILTER_NULL_ON_FAILURE)) {
            return $value;
        }

        return $sanitized;
    }
}

if (! \function_exists('arr')) {
    function arr(array $values = []): Arr
    {
        return Arr::of($values);
    }
}

if (! \function_exists('csrf')) {
    function csrf(): string
    {
        return Csrf::render();
    }
}
