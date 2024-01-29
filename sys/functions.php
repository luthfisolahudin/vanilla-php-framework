<?php

declare(strict_types=1);

use Sys\App;
use Sys\Config\ConfigInterface;
use Sys\Http\Router\RouterInterface;
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

if (! \function_exists('config')) {
    function config(): ConfigInterface
    {
        return App::container()->get(ConfigInterface::class);
    }
}

if (! \function_exists('router')) {
    function router(): RouterInterface
    {
        return App::container()->get(RouterInterface::class);
    }
}

if (! \function_exists('view')) {
    function view(): ViewInterface
    {
        return App::container()->get(ViewInterface::class);
    }
}
