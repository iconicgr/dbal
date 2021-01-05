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

        $connectionString = "mysql:host=$host;dbname=$database;charset=utf8mb4";
        try{
            $this->connection = new PDO($connectionString, $user, $password, $options);
        }
        catch (\Exception $exception){
            throw new \Exception($exception->getMessage() . ': '. json_encode(['connection' => $connectionString, 'user' => $user, 'password' => $password]));
        }
    }
}