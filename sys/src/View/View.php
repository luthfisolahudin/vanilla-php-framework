<?php

declare(strict_types=1);

namespace Sys\View;

use Sys\Config\ConfigInterface;
use Sys\View\Exception\NotFoundException;

class View implements ViewInterface
{
    public const NAMESPACE_SEPARATOR = ':';

    public const EXTENSION = '.view.php';

    protected array $folders;

    protected string $defaultFolder;

    public function __construct(
        protected ConfigInterface $config,
        protected ViewEngineInterface $engine,
    ) {
        $this->defaultFolder = $this->config->get('view_default', app_path('views'));
        $this->folders = $this->config->get('views', []);
    }

    public function exists(string $path): bool
    {
        return file_exists($this->resolvePath($path, false));
    }

    public function resolvePath(string $path, bool $ensureExists = true): string
    {
        if (! str_contains($path, static::NAMESPACE_SEPARATOR)) {
            $resolved = "{$this->defaultFolder}/{$path}".static::EXTENSION;

            if ($ensureExists && ! file_exists($resolved)) {
                throw new NotFoundException("View {$resolved} doesn't exist");
            }

            return $resolved;
        }

        [$namespace, $path] = explode(static::NAMESPACE_SEPARATOR, $path, 2);

        if (! \array_key_exists($namespace, $this->folders)) {
            throw new NotFoundException("Unrecognized namespace {$namespace}");
        }

        $resolved = "{$this->folders[$namespace]}/{$path}".static::EXTENSION;

        if ($ensureExists && ! file_exists($resolved)) {
            throw new NotFoundException("View {$resolved} doesn't exist in namespace {$namespace}");
        }

        return $resolved;
    }

    public function render(string $path, array $data = []): string
    {
        $renderer = static function (string $__path, array $__data, ViewEngineInterface $v): string {
            extract($__data);
            ob_start();

            require $__path;

            return ob_get_clean();
        };

        while (true) {
            $html = $renderer($this->resolvePath($path), $data, $this->engine);

            if (null === $this->engine->extends()) {
                return $html;
            }

            $path = $this->engine->extends();
            $data = ['slot' => $html];
            $this->engine->flush();
        }
    }
}
