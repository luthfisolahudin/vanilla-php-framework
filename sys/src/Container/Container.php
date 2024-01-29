<?php

declare(strict_types=1);

namespace Sys\Container;

use Sys\Container\Exception\TypeResolutionException;

class Container implements ContainerInterface
{
    protected array $resolvers = [];

    protected array $singleton = [];

    protected array $alias = [];

    public function bind(string $key, \Closure $resolver): static
    {
        $this->resolvers[$key] = $resolver;

        return $this;
    }

    /**
     * @throws \ReflectionException
     * @throws TypeResolutionException
     */
    public function singleton(string $key, ?\Closure $resolver = null): static
    {
        $key = $this->getAlias($key);
        $this->singleton[$key] = null !== $resolver ? $resolver() : $this->get($key);

        return $this;
    }

    public function alias(string $key, string $actual): static
    {
        $this->alias[$key] = $actual;

        return $this;
    }

    /**
     * @template T of object
     *
     * @param $key class-string<T>
     *
     * @throws \ReflectionException
     * @throws TypeResolutionException
     */
    public function get(string $key): mixed
    {
        $key = $this->getAlias($key);

        if ($this->isSingleton($key)) {
            return $this->singleton[$key];
        }

        if (! $this->has($key)) {
            $this->resolvers[$key] = $this->createResolver($key);
        }

        return $this->resolvers[$key]();
    }

    public function getAlias(string $key): string
    {
        return $this->alias[$key] ?? $key;
    }

    public function has(string $key): bool
    {
        return \array_key_exists($this->getAlias($key), $this->resolvers) || $this->isSingleton($key);
    }

    public function isSingleton(string $key): bool
    {
        return \array_key_exists($this->getAlias($key), $this->singleton);
    }

    /**
     * @throws \ReflectionException
     * @throws TypeResolutionException
     */
    protected function createResolver(string $type): object
    {
        if (! $this->isInstantiatable($type)) {
            throw new TypeResolutionException("{$type} is not instantiatable");
        }

        $class = new \ReflectionClass($type);
        $constructor = $class->getConstructor();

        if (null === $constructor) {
            return fn () => new $type();
        }

        if (! $constructor->isPublic()) {
            throw new TypeResolutionException("Couldn't initiate {$type}, constructor not public");
        }

        $params = [];

        foreach ($constructor->getParameters() as $parameter) {
            $params[] = $this->get((string) $parameter->getType());
        }

        return fn () => new $type(...$params);
    }

    protected function isInstantiatable(string $type): bool
    {
        return 'Closure' !== $type && ! \is_callable($type) && class_exists($type);
    }
}
