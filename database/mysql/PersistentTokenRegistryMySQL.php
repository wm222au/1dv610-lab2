<?php

namespace Database;

class PersistentTokenRegistryMySQL extends PersistentRegistryMySQL implements \Interfaces\IPersistentRegistry
{
    public function get($token): string
    {
        $queryString = "SELECT token FROM Tokens WHERE BINARY token = {$token} LIMIT 1";
        $db->query($queryString);
    }

    public function exists($token): bool
    {}

    public function compare($token): bool
    {}

    public function add($token)
    {
        $token = "blabla";
        $queryString = "INSERT INTO Tokens (token) VALUES ($token)";
    }
}
