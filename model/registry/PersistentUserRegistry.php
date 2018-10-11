<?php

namespace Model\Registry;

class PersitentUserRegistry extends Registry
{
    private static $hashOptions = ['cost' => 20];

    public function getUser($user): \Model\User
    {
        $escapedUsername = mysqli::real_escape_string($user->getUsername());

        $queryString = "SELECT * FROM users WHERE BINARY username = {$escapedUsername} LIMIT 1";

        $db->query($queryString);
    }

    public function addUser($user)
    {
        $token = "blabla";
        $hashedPassword = $this->hash($user->getPassword());
        $escapedUsername = mysqli::real_escape_string($user->getUsername());

        $queryString = "INSERT INTO Users
        (username, password, tokenId)
        VALUES
        ('$escapedUsername', '$hashedPassword', 'SELECT id FROM Tokens WHERE token = {$token}')";

        $db->query($queryString);
    }

    private static function hash(string $clearTextPassword): string
    {
        return password_hash($clearTextPassword, PASSWORD_BCRYPT, SELF::$hashOptions);
    }
}
