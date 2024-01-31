<?php

declare(strict_types=1);

namespace Sys\Config;

interface ConfigInterface
{
    public function load(array $values, bool $recursive = true): static;

    public function set(string $key, mixed $value): static;

    public function has(string $key): bool;

    public function get(string $key, mixed $default = null): mixed;

    public function all(): array;
}
