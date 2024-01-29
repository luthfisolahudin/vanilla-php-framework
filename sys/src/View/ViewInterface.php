<?php

declare(strict_types=1);

namespace Sys\View;

interface ViewInterface
{
    public function exists(string $path): bool;

    public function resolvePath(string $path, bool $ensureExists = true): string;

    public function render(string $path, array $data = []): string;
}
