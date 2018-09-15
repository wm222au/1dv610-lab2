<?php

namespace Model;

class User
{
    private $username;
    private $password;
    private static $hashOptions = ['cost' => 12];

    public function __construct()
    {
    }

    private static function hash(string $clearTextPW)
    {
        return password_hash($clearTextPW, PASSWORD_BCRYPT, SELF::$hashOptions);
    }

    public function registerToDB()
    {

    }

    public function login(string $username, string $password)
    {
        $this->username = $username;
        $this->password = SELF::hash($password);
    }

    public function isUserLoggedIn()
    {
        return true;
    }
}
