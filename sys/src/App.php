<?php

declare(strict_types=1);

namespace Sys;

use Sys\Container\ContainerInterface;

class App
{
    protected static ContainerInterface $container;

    public static function setContainer(ContainerInterface $container): ContainerInterface
    {
        return static::$container = $container;
    }

    public static function container(): ContainerInterface
    {
        return static::$container;
    }
}
