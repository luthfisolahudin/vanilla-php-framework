<?php

namespace Sys\Support;

class Csrf
{
    public const DEFAULT_NAME = '__token__';

    public static function name(): string
    {
        return config()->get('csrf.name', static::DEFAULT_NAME);
    }

    public static function token(): string
    {
        return session()->token();
    }

    public static function render(): string
    {
        $name = static::name();
        $token = static::token();

        return <<<HTML
            <input type="hidden" name="{$name}" value="{$token}" />
            HTML;
    }
}
