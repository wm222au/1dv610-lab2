<?php

namespace Model;

class User
{
    private $username = '';
    private $password = '';
    private static $hashOptions = ['cost' => 12];

    public function getUsername()
    {
        return $this->username;
    }

    private function setUsername()
    {}

    public function getPassword()
    {
        return $this->password;
    }

    private function setPassword()
    {}

    private static function hash(string $clearTextPassword)
    {
        return password_hash($clearTextPassword, PASSWORD_BCRYPT, SELF::$hashOptions);
    }

    public function registerToDatabase($username, $password)
    {
        global $db;

        $hashedPassword = self::hash($password);

        $queryString = "INSERT INTO Users (username, password) VALUES ('$username', '$hashedPassword')";

        return $db->query($queryString);
    }

    public function loginWithPassword($_username, $_password): string
    {
        global $db;

        $queryString = "SELECT * FROM Users WHERE username = $_username LIMIT 1";
        $result = $db->query($queryString);

        if ($result && $result->num_rows > 0) {
            $user = mysql_fetch_assoc($result);

            if (password_verify($_password, $user['password'])) {
                $this->username = $user['username'];
                $this->password = $user['password'];
            } else {
                throw new Exception('Password did not match.');
            }

            return true;
        } else {
            return false;
        }
    }

    public function isUserLoggedIn()
    {
        return true;
    }
}
