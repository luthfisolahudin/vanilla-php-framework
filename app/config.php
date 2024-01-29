<?php

declare(strict_types=1);

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
