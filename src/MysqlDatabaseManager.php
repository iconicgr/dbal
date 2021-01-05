<?php


namespace Iconic\Dbal;


use PDO;
use Psr\Log\LoggerInterface;

class MysqlDatabaseManager extends PdoDatabaseManager
{
    public function __construct(string $host, string $database, string $user, string $password = '', LoggerInterface $logger = null)
    {
        $this->logger = $logger;

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try{
            $this->connection = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $user, $password, $options);
        }
        catch (\Exception $exception){
            throw new \Exception($exception->getMessage() . ': '. json_encode(['host' => $host, 'database' => $database, 'user' => $user, 'password' => $password]));
        }
    }
}