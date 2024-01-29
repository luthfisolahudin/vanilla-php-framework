<?php

declare(strict_types=1);

// inspired from https://gist.github.com/mhull/61832ecd957821c8912b446e98ddcfde#file-3-autoload-php
spl_autoload_register(static function ($class): void {
    $extension = '.php';
    $namespaces = [
        'App\\' => BASE_PATH.'/app',
        'Sys\\' => BASE_PATH.'/sys/src',
    ];

    foreach ($namespaces as $prefix => $folder) {
        if (! str_starts_with($class, $prefix)) {
            continue;
        }

        // remove namespace prefix
        $class = str_replace($prefix, '', $class);

        // convert namespace to path
        $filePath = rtrim($folder, '/\\').'/'.str_replace('\\', '/', $class).$extension;

        // if file exist, require and return
        if (file_exists($filePath)) {
            require $filePath;

            return;
        }
    }
});

require_once BASE_PATH.'/sys/functions.php';
require_once BASE_PATH.'/app/functions.php';
