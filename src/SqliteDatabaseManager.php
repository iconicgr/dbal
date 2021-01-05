<?php


namespace Iconic\Dbal;


use Psr\Log\LoggerInterface;

class SqliteDatabaseManager extends PdoDatabaseManager
{
    public function __construct(string $filepath, LoggerInterface $logger = null)
    {
        $this->connection = new \PDO("sqlite:$filepath");
        $this->logger = $logger;
    }
}