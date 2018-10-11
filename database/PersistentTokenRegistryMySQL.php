<?php

namespace Database;

class PersitentTokenRegistry extends PersistentRegistryMySQL implements \Inter\IPersistentTokenRegistry
{
    public function getToken($token): string
    {
        $queryString = "SELECT token FROM Tokens WHERE BINARY token = {$token} LIMIT 1";
        $db->query($queryString);
    }

    public function hasToken($token): bool
    {}

    public function addToken($token)
    {
        $token = "blabla";
        $queryString = "INSERT INTO Tokens (token) VALUES ($token)";
    }
}
