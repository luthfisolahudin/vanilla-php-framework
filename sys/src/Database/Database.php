<?php

declare(strict_types=1);

namespace Sys\Database;

use Sys\App;
use Sys\Config\ConfigInterface;

class Database implements DatabaseInterface
{
    protected ?\PDO $connection = null;

    public function __construct(
        protected ConfigInterface $config,
    ) {}

    public function query(string $query, array $params = []): StatementInterface
    {
        $statement = $this->connection()->prepare($query);

        $statement->execute($params);

        return App::container()->getAlias(StatementInterface::class)::fromPdo($statement);
    }

    public function connection(): \PDO
    {
        if (null === $this->connection) {
            $config = [
                'host' => $this->config->get('database.host', '127.0.0.1'),
                'port' => $this->config->get('database.port', 3306),
                'dbname' => $this->config->get('database.dbname', 'vanilla_php'),
                'charset' => $this->config->get('database.charset', 'utf8mb4'),
            ];
            $username = $this->config->get('database.username', 'vanilla_php');
            $password = $this->config->get('database.password', '');

            $dsn = 'mysql:'.http_build_query($config, '', ';');

            $this->connection = new \PDO($dsn, $username, $password, [\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC]);
        }

        return $this->connection;
    }
}
