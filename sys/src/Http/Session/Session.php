<?php

declare(strict_types=1);

namespace Sys\Http\Session;

class Session implements SessionInterface
{
    public function get(string $key, mixed $default = null): mixed
    {
        return sanitize($_SESSION[static::FLASH_KEY][$key] ?? $_SESSION[$key] ?? $default);
    }

    public function set(string $key, mixed $value): static
    {
        $_SESSION[$key] = sanitize($value);

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
        $_SESSION[static::FLASH_KEY][$key] = sanitize($value);

        return $this;
    }

    public function unflash(?string $key = null): mixed
    {
        if (null === $key) {
            return $this->unset(static::FLASH_KEY);
        }

        $value = sanitize($_SESSION[static::FLASH_KEY][$key] ?? null);

        unset($_SESSION[static::FLASH_KEY][$key]);

        return $value;
    }

    public function token(): string
    {
        if (null !== $value = $this->get(static::TOKEN_KEY)) {
            return $value;
        }

        $this->set(static::TOKEN_KEY, $value = $this->generateToken());

        return $value;
    }

    public function regenerateToken(): string
    {
        $this->set(static::TOKEN_KEY, $value = $this->generateToken());

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

    protected function generateToken(int $minLength = 256): string
    {
        $token = '';

        while (\strlen($token) < $minLength) {
            $random = base64_encode((string) random_int(0, mt_getrandmax()));
            $token .= preg_replace('/[^[:alnum:]]/', '', $random);
        }

        return $token;
    }
}
