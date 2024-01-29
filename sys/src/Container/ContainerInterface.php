<?php

declare(strict_types=1);

namespace Sys\Container;

interface ContainerInterface
{
    public function bind(string $key, \Closure $resolver): static;

    public function singleton(string $key, ?\Closure $resolver = null): static;

    public function alias(string $key, string $actual): static;

    public function get(string $key): mixed;

    public function getAlias(string $key): string;

    public function has(string $key): bool;

    public function isSingleton(string $key): bool;
}
