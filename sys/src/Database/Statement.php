<?php

declare(strict_types=1);

namespace Sys\Database;

class Statement implements StatementInterface
{
    protected ?Mappable $map = null;

    public function __construct(
        protected \PDOStatement $statement,
    ) {}

    public function setMap(Mappable $map): static
    {
        $this->map = $map;

        return $this;
    }

    public function get(): array|Mappable
    {
        return array_map(fn ($v) => $this->map($v), $this->statement->fetchAll());
    }

    public function fetch(): array|Mappable|null
    {
        return $this->map($this->statement->fetch());
    }

    protected function map(?array $values): array|Mappable|null
    {
        if (null === $values) {
            return null;
        }

        if (null === $this->map) {
            return $values;
        }

        return $this->map::fromDatabase($values);
    }

    public static function fromPdo(\PDOStatement $statement): static
    {
        return new static($statement);
    }
}
