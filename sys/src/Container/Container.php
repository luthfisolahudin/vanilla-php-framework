<?php

declare(strict_types=1);

namespace Sys\Container;

use Sys\Container\Exception\TypeResolutionException;

class Container implements ContainerInterface
{
    protected array $resolvers = [];

    protected array $singleton = [];

    protected array $instances = [];

    protected array $aliases = [];

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
        $this->singleton[] = $key;

        if (null !== $resolver) {
            $this->bind($key, $resolver);
        }

        return $this;
    }

    public function alias(string $key, string $actual): static
    {
        $this->aliases[$key] = $actual;

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
    public function get(string $key, array $params = []): mixed
    {
        $key = $this->getAlias($key);

        if (\array_key_exists($key, $this->instances)) {
            return $this->instances[$key];
        }

        if (! $this->has($key)) {
            $this->resolvers[$key] = $this->createResolver($key, $params);
        }

        $instance = $this->resolvers[$key]();

        if ($this->isSingleton($key)) {
            $this->instances[$key] = $instance;
        }

        return $instance;
    }

    public function getAlias(string $key): string
    {
        return $this->aliases[$key] ?? $key;
    }

    public function has(string $key): bool
    {
        return \array_key_exists($this->getAlias($key), $this->resolvers);
    }

    public function isSingleton(string $key): bool
    {
        return \in_array($this->getAlias($key), $this->singleton);
    }

    /**
     * @throws \ReflectionException
     * @throws TypeResolutionException
     */
    protected function createResolver(string $type, array $params = []): object
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

        $dependencies = [];

        foreach ($constructor->getParameters() as $parameter) {
            $paramType = $parameter->getType();

            if (\array_key_exists($paramType->getName(), $params)) {
                $dependencies[] = $params[$paramType->getName()];

                continue;
            }

            if (! $this->isInstantiatable((string) $paramType)) {
                if ($parameter->isDefaultValueAvailable()) {
                    $dependencies[] = $parameter->getDefaultValue();

                    continue;
                } elseif ($paramType->allowsNull()) {
                    $dependencies[] = null;

                    continue;
                }
            }

            $dependencies[] = $this->get((string) $paramType);
        }

        return fn () => new $type(...$dependencies);
    }

    protected function isInstantiatable(string $type): bool
    {
        return 'Closure' !== $type && ! \is_callable($type) && class_exists($type);
    }
}
