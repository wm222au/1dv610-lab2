<?php

namespace Model;

class Register
{
    private $username;
    private $password;
    private $repeatedPassword;

    private $minUsernameLength = 3;
    private $minPasswordLength = 6;

    public function __construct($username, $password, $repeatedPassword)
    {
        $this->username = $username;
        $this->password = $password;
        $this->repeatedPassword = $repeatedPassword;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getRepeatedPassword()
    {
        return $this->repeatedPassword;
    }

    public function isRegistrationValid(): bool
    {
        return ($this->isUsernameValid() && $this->isPasswordValid());
    }

    public function isUsernameValid(): bool
    {
        return (strlen($this->username) < $this->minUsernameLength);
    }

    public function isPasswordValid(): bool
    {
        if ($this->password != $this->repeatedPassword || strlen($this->password) < $this->minPasswordLength) {
            return false;
        }

        return true;
    }
}
