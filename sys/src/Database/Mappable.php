<?php

declare(strict_types=1);

namespace Sys\Database;

interface Mappable
{
    public static function fromDatabase(array $values): static;
}
