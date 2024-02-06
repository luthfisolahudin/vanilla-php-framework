<?php

declare(strict_types=1);

namespace Sys\Support;

class Arr implements \ArrayAccess, \JsonSerializable
{
    public const DELIMITER = '.';

    public function __construct(
        protected array $values = [],
    ) {}

    public static function of(array $values = []): static
    {
        return new static($values);
    }

    public function set(string $key, mixed $value): static
    {
        $values = &$this->values;
        $keys = $this->explodeKeys($key);
        $lastKey = array_pop($keys);

        foreach ($keys as $key) {
            if (! \array_key_exists($key, $values)) {
                $values[$key] = [];
            }

            $values = &$values[$key];
        }

        $values[$lastKey] = $value;

        return $this;
    }

    public function unset(string $key): mixed
    {
        $values = &$this->values;
        $keys = $this->explodeKeys($key);
        $lastKey = array_pop($keys);

        foreach ($keys as $key) {
            if (! \array_key_exists($key, $values)) {
                return null;
            }

            $values = &$values[$key];
        }

        if (! \array_key_exists($lastKey, $values)) {
            return null;
        }

        $removedValue = $values[$lastKey];

        unset($values[$lastKey]);

        return $removedValue;
    }

    public function has(string $key): bool
    {
        $values = &$this->values;

        foreach ($this->explodeKeys($key) as $key) {
            if (! \array_key_exists($key, $values)) {
                return false;
            }

            $values = &$values[$key];
        }

        return null !== $values;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        $values = &$this->values;

        foreach ($this->explodeKeys($key) as $nestedKey) {
            if (! \array_key_exists($nestedKey, $values)) {
                return $default;
            }

            $values = &$values[$nestedKey];
        }

        return $values;
    }

    public function all(): array
    {
        return $this->values;
    }

    public function merge(array ...$values): static
    {
        $this->values = array_merge($this->values, ...$values);

        return $this;
    }

    public function mergeRecursive(array ...$values): static
    {
        $this->values = array_merge_recursive($this->values, ...$values);

        return $this;
    }

    protected function explodeKeys(string $key): array
    {
        return array_map(
            fn ($value) => is_numeric($value) ? (int) $value : $value,
            explode(static::DELIMITER, $key),
        );
    }

    public function offsetExists(mixed $offset): bool
    {
        return $this->has($offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->get($offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->set($offset, $value);
    }

    public function offsetUnset(mixed $offset): void
    {
        $this->unset($offset);
    }

    public function jsonSerialize(): array
    {
        return $this->values;
    }
}
