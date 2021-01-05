<?php


namespace Iconic\Dbal;


use PDO;
use Psr\Log\LoggerInterface;

abstract class PdoDatabaseManager
{
    protected PDO $connection;
    protected ?LoggerInterface $logger;

    public function execute(string $query, string $class = null, array $parameters = null): DatabaseResult
    {
        $now = microtime(true);
        $statement = $this->connection->prepare($query);
        $statement->execute($parameters);
        $result = $statement->fetchAll(\PDO::FETCH_CLASS, $class);
        $rows = $statement->rowCount();
        $lastId = $this->connection->lastInsertId();
        $last = microtime(true);
        $time = round(($last - $now) * 1000, 2);
        $this->logger->debug('Query: '.$statement->queryString);
        $this->logger->debug('Parameters: '.json_encode($parameters));
        $this->logger->debug('Execution time: '.$time.'ms');
        $this->logger->debug("Rows involved: $rows");

        $array = explode('\\', $class);
        $objectName = end($array);

        return new DatabaseResult(
            $result,
            $rows,
            $lastId,
            str_replace('::class', '', $objectName)
        );
    }
}