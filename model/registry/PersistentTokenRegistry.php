<?php

namespace Model\Registry;

class PersitentTokenRegistry extends Registry
{
    public function getToken(): string
    {
        $queryString = "SELECT token FROM Tokens WHERE BINARY token = {$token} LIMIT 1";
        $db->query($queryString);
    }

    // public function hasToken($token): bool
    // {
    //     $queryString = "SELECT token FROM Tokens WHERE BINARY token = {$token} LIMIT 1";
    //     $db->query($queryString);
    //     $this->getToken();
    //     return count($db->getResults()) > 0 ? true : false;
    // }

    public function addToken($token)
    {
        $token = "blabla";
        $queryString = "INSERT INTO Tokens (token) VALUES ($token)";
    }
}
