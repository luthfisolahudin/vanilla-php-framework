<?php

declare(strict_types=1);

namespace Sys\Http\Session;

interface SessionInterface
{
    public const FLASH_KEY = '__FLASH__';

    public const TOKEN_KEY = '__CSRF_TOKEN__';

    public function get(string $key, mixed $default = null): mixed;

    public function set(string $key, mixed $value): static;

    public function unset(string $key): mixed;

    public function flash(string $key, mixed $value): static;

    public function unflash(?string $key = null): mixed;

    public function token(): string;

    public function regenerateToken(): string;

    public function flush(): void;

    public function destroy(): void;
}
