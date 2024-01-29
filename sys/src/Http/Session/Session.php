<?php

declare(strict_types=1);

namespace Sys\Http\Session;

class Session implements SessionInterface
{
    public function get(string $key, mixed $default = null): mixed
    {
        return $_SESSION[static::FLASH_KEY][$key] ?? $_SESSION[$key] ?? $default;
    }

    public function set(string $key, mixed $value): static
    {
        $_SESSION[$key] = $value;

        return $this;
    }

    public function unset(string $key): mixed
    {
        $value = $this->get($key);

        unset($_SESSION[$key]);

        return $value;
    }

    public function flash(string $key, mixed $value): static
    {
        $_SESSION[static::FLASH_KEY][$key] = $value;

        return $this;
    }

    public function unflash(?string $key = null): mixed
    {
        if (null === $key) {
            return $this->unset(static::FLASH_KEY);
        }

        $value = $_SESSION[static::FLASH_KEY][$key] ?? null;

        unset($_SESSION[static::FLASH_KEY][$key]);

        return $value;
    }

    public function flush(): void
    {
        $_SESSION = [];
    }

    public function destroy(): void
    {
        static::flush();

        session_destroy();
        session_regenerate_id(true);
    }
}
