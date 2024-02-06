<?php

declare(strict_types=1);

namespace Sys\Database;

interface StatementInterface
{
    public function setMap(Mappable $map): static;

    public function get(): array|Mappable;

    public function fetch(): array|Mappable|null;
}
