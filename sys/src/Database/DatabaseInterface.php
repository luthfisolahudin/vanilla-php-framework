<?php

declare(strict_types=1);

namespace Sys\Database;

interface DatabaseInterface
{
    public function query(string $query, array $params = []): StatementInterface;

    public function connection(): \PDO;
}
