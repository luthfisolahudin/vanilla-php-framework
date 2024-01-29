<?php

declare(strict_types=1);

namespace Sys\Http\Auth;

interface Identifiable
{
    public function identity(): mixed;
}
