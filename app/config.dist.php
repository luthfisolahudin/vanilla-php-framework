<?php

declare(strict_types=1);

use Sys\Http\Middleware\CsrfMiddleware;

return [
    'app' => [
        'name' => 'Vanilla PHP',
    ],

    'locale' => [
        // references https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes/lang
        'default' => 'id',
    ],

    'database' => [
        'host' => 'localhost',
        'port' => 3306,
        'dbname' => 'vanilla_php',
        'username' => 'root',
        'password' => '',
    ],

    // global middleware
    'middleware' => [
        'default' => [CsrfMiddleware::class],
        'auth' => ['redirect' => '/login'],
        'guest' => ['redirect' => '/home'],
    ],

    'views' => [
        'default' => app_path('views'),
        'errors' => [
            'any' => app_path('views/error/any'),
        ],
        'namespaces' => [
            // <string>: <string>
        ],
    ],
];
