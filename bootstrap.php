<?php

declare(strict_types=1);

use Sys\App;
use Sys\Config\Config;
use Sys\Config\ConfigInterface;
use Sys\Container\Container;
use Sys\Database\Database;
use Sys\Database\DatabaseInterface;
use Sys\Database\Statement;
use Sys\Database\StatementInterface;
use Sys\Http\Auth\Auth;
use Sys\Http\Auth\AuthenticatorInterface;
use Sys\Http\Auth\AuthInterface;
use Sys\Http\Auth\UserAuthenticator;
use Sys\Http\Request\Request;
use Sys\Http\Request\RequestInterface;
use Sys\Http\Router\Router;
use Sys\Http\Router\RouterInterface;
use Sys\Http\Session\Session;
use Sys\Http\Session\SessionInterface;
use Sys\View\View;
use Sys\View\ViewEngine;
use Sys\View\ViewEngineInterface;
use Sys\View\ViewInterface;

App::setContainer(
    (new Container())
        ->alias(ConfigInterface::class, Config::class)
        ->alias(DatabaseInterface::class, Database::class)
        ->alias(StatementInterface::class, Statement::class)
        ->alias(SessionInterface::class, Session::class)
        ->alias(AuthInterface::class, Auth::class)
        ->alias(AuthenticatorInterface::class, UserAuthenticator::class)
        ->alias(RouterInterface::class, Router::class)
        ->alias(RequestInterface::class, Request::class)
        ->alias(ViewInterface::class, View::class)
        ->alias(ViewEngineInterface::class, ViewEngine::class)
        ->singleton(ConfigInterface::class, static function () {
            $values = array_merge_recursive(
                (@include app_path('config.dist.php')) ?: [],
                (@include app_path('config.php')) ?: [],
            );

            return (new Config())->load($values);
        })
        ->singleton(RouterInterface::class)
);
