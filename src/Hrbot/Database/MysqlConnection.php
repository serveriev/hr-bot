<?php

namespace Hrbot\Database;

use Hrbot\Configuration\ConfigurationInterface;
use Hrbot\Exception\DatabaseConnectionException;

class MysqlConnection implements ConnectionInterface
{
    private $configuration;

    public function __construct(ConfigurationInterface $configuration)
    {
        $this->configuration = $configuration->getDatabaseConfig();
    }

    public function getConnection(): \PDO
    {
        try {
            $dsn = sprintf('mysql:host=%s:%d;dbname=%s',
                $this->configuration->getHost(),
                $this->configuration->getPort(),
                $this->configuration->getName()
            );

            $connection = new \PDO(
                $dsn,
                $this->configuration->getUser(),
                $this->configuration->getPassword()
            );
            $connection->exec('SET CHARACTER SET utf8');
        } catch (\PDOException $e) {
            throw new DatabaseConnectionException();
        }

        return $connection;
    }
}
