<?php

declare(strict_types=1);

namespace Sys\Http\Controller;

interface ControllerInterface
{
    public function __invoke();
}
