<?php

namespace Model;

use Exception;

class PasswordEmptyException extends Exception
{}
class PasswordTooShortException extends Exception
{}

class Password
{
    private $password;
    private static $minPasswordLength = 6;

    public function __construct(string $password)
    {
        $this->set($password);
    }

    public function get(): string
    {
        return $this->password;
    }

    private function set(string $password)
    {
        if (empty($password)) {
            throw new \Model\PasswordEmptyException();
        } else if (strlen($password) <= self::$minPasswordLength) {
            throw new \Model\PasswordTooShortException();
        }
        $this->password = $password;
    }
}
