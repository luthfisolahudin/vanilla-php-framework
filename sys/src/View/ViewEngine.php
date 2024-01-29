<?php

declare(strict_types=1);

namespace Sys\View;

class ViewEngine implements ViewEngineInterface
{
    protected ?string $layout = null;

    protected array $persist = [];

    public function extends(?string $path = null): ?string
    {
        if (null === $path) {
            return $this->layout;
        }

        $this->layout = $path;

        return null;
    }

    public function persist(string $key, mixed $value = null): mixed
    {
        if (null === $value) {
            return $this->persist[$key] ?? null;
        }

        $this->persist[$key] = $value;

        return null;
    }

    public function flush(): void
    {
        $this->layout = null;
    }
}
