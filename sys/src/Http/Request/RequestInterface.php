<?php

declare(strict_types=1);

namespace Sys\Http\Request;

use Sys\Http\Auth\AuthInterface;
use Sys\Http\Session\SessionInterface;
use Sys\Http\Status;

interface RequestInterface
{
    public function get(string $key, mixed $default = null): mixed;

    public function auth(): AuthInterface;

    public function isAuthenticated(): bool;

    public function session(): SessionInterface;

    public function abort(int $code = Status::NOT_FOUND): void;
}
