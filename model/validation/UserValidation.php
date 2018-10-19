<?php

namespace Model;

class UserValidationFailure extends \Exception
{
    private $validation;

    public function __construct(\Model\UserValidation $validation, string $message = "User creation failed")
    {
        parent::__construct($message, 0, null);
        $this->validation = $validation;
    }

    public function getUserValidation(): \Model\UserValidation
    {
        return $this->validation;
    }
}

class UserValidation extends User
{
    public static $minUsernameLength = 3;
    public static $minPasswordLength = 6;

    public function isUsernameEmpty(): bool
    {
        return empty($this->username);
    }

    public function isPasswordEmpty(): bool
    {
        return empty($this->password);
    }

    public function isUsernameTooShort(): bool
    {
        return strlen($this->username) < self::$minUsernameLength;
    }

    public function isPasswordTooShort(): bool
    {
        return strlen($this->password) < self::$minPasswordLength;
    }

    public function isUsernameCharactersInvalid(): bool
    {
        return strip_tags($this->username) != $this->username;
    }

    public function isValid(): bool
    {
        // If all validations pass, user is valid
        if(
            !$this->isUsernameEmpty() &&
            !$this->isPasswordEmpty() &&
            !$this->isUsernameTooShort() &&
            !$this->isPasswordTooShort() &&
            !$this->isUsernameCharactersInvalid()
        ) {
            return true;
        }

        return false;
    }
}