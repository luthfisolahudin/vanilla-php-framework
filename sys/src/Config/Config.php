<?php

declare(strict_types=1);

namespace Sys\Config;

class Config implements ConfigInterface
{
    public const DELIMITER = '.';

    protected array $config = [];

    public function load(array $values): static
    {
        $this->config = array_merge($this->config, $values);

        return $this;
    }

    public function set(string $key, mixed $value): static
    {
        $config = &$this->config;

        foreach ($this->explodeKeys($key) as $nestedKey) {
            $config = &$config[$nestedKey];
        }

        $config = $value;

        return $this;
    }

    public function has(string $key): bool
    {
        $config = &$this->config;

        foreach ($this->explodeKeys($key) as $nestedKey) {
            if (! isset($config[$nestedKey])) {
                return false;
            }

            $config = &$config[$nestedKey];
        }

        return true;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        $config = &$this->config;

        foreach ($this->explodeKeys($key) as $nestedKey) {
            if (! isset($config[$nestedKey])) {
                return $default;
            }

            $config = &$config[$nestedKey];
        }

        return $config;
    }

    public function all(): array
    {
        return $this->config;
    }

    protected function explodeKeys(string $key): array
    {
        return array_map(fn ($v) => is_numeric($v) ? (int) $v : $v, explode(static::DELIMITER, $key));
    }
}
