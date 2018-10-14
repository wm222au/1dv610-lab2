<?php

namespace Database;

class PersistentTokenRegistryMySQL extends PersistentRegistryMySQL
{
    private $dbTable = "Tokens";

    public function get($token): string
    {
        $queryString = "SELECT token FROM {$this->dbTable} WHERE BINARY token = {$token} LIMIT 1";
        $db->query($queryString);
    }

    public function exists($token): bool
    {}

    public function compare($token): bool
    {}

    public function add($token)
    {
        $token = "blabla";
        $queryString = "INSERT INTO {$this->dbTable} (token) VALUES ($token)";
    }
}
