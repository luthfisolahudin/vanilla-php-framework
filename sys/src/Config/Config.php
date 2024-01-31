<?php

declare(strict_types=1);

namespace Sys\Config;

use Sys\Support\Arr;

class Config implements ConfigInterface
{
    protected Arr $config;

    public function __construct()
    {
        $this->config = arr();
    }

    public function load(array $values, bool $recursive = true): static
    {
        $this->config->merge($values);

        return $this;
    }

    public function set(string $key, mixed $value): static
    {
        $this->config->set($key, $value);

        return $this;
    }

    public function has(string $key): bool
    {
        $this->config->has($key);

        return true;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->config->get($key, $default);
    }

    public function all(): array
    {
        return $this->config->all();
    }
}
