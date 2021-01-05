<?php


namespace Iconic\Dbal;


class DatabaseResult
{
    public int $rows;
    public array $results;
    public int $lastInsertedId;
    public string $objectName;

    public function __construct($results, $rows, $lastInsertedId, $objectName)
    {
        $this->rows = $rows;
        $this->results = $results;
        $this->lastInsertedId = $lastInsertedId;
        $this->objectName = $objectName;
    }

    public function objectOrException(string $objectName)
    {
        if ($this->rows > 0) {
            return $this->results[0];
        }

        throw new \Exception("$objectName not found.");
    }

    public function successOrException()
    {
        if ($this->rows < 1) {
            throw new \Exception("No changes saved for $this->objectName.");
        }

        return $this->rows;
    }
}