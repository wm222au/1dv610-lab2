<?php

namespace Model;

class User
{
    private $username;
    private $password;

    public static $minUsernameLength = 3;
    public static $minPasswordLength = 6;

    public function __construct(string $username, string $password)
    {
        $this->setUsername($username);
        $this->setPassword($password);
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    private function setUsername($username)
    {
        if (empty($username)) {
            throw new \Model\UsernameEmptyException();
        } else if (strlen($username) <= self::$minUsernameLength) {
            throw new \Model\UsernameTooShortException();
            // Check if username contains valid username tags
        } else if (strip_tags($username) !== $username) {
            throw new \Model\UsernameCharactersInvalidException();
        }
        $this->username = $username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    private function setPassword($password)
    {
        if (empty($password)) {
            throw new \Model\PasswordEmptyException();
        } else if (strlen($password) <= self::$minPasswordLength) {
            throw new \Model\PasswordTooShortException();
        }
        $this->password = $password;
    }
}
