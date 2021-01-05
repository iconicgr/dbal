<?php


namespace Iconic\Dbal;


interface DatabaseManagerInterface
{
    public function execute(string $query, string $class = null, array $parameters = null): DatabaseResult;
}