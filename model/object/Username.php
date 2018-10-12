<?php

namespace Model;

use Exception;

class UsernameEmptyException extends Exception
{}
class UsernameTooShortException extends Exception
{}
class UsernameCharactersInvalidException extends Exception
{}

class Username
{
    private $username;
    private static $minUsernameLength = 3;

    public function __construct(string $username)
    {
        var_dump(strlen($username) <= self::$minUsernameLength);
        $this->set($username);
    }

    public function get(): string
    {
        return $this->username;
    }

    private function set(string $username)
    {
        var_dump(strlen($username) <= self::$minUsernameLength);
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
}
