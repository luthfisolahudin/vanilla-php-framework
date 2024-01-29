<?php

declare(strict_types=1);

namespace Sys\View;

interface ViewEngineInterface
{
    public function extends(?string $path = null): ?string;

    public function persist(string $key, mixed $value = null): mixed;

    public function flush(): void;
}
