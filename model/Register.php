<?php

namespace Model;

class Register
{
    private $usernameLengthValid = false;
    private $passwordLengthValid = false;
    private $passwordsEqual = false;

    private $minUsernameLength;
    private $minPasswordLength;

    public function __construct(\Model\User $user, $repeatedPassword)
    {
        $this->usernameLengthValid = $user->isUsernameValid();
        $this->passwordLengthValid = $user->isPasswordValid();
        $this->passwordsEqual = $user->getPassword() == $repeatedPassword;

        $this->minUsernameLength = $user::$minUsernameLength;
        $this->minPasswordLength = $user::$minPasswordLength;
    }

    public function getUsernameLengthValid(): bool
    {
        return $this->usernameLengthValid;
    }

    public function getPasswordLengthValid(): bool
    {
        return $this->passwordLengthValid;
    }

    public function getPasswordsEqual(): bool
    {
        return $this->passwordsEqual;
    }

    public function getMinUsernameLength(): int
    {
        return $this->minUsernameLength;
    }

    public function getMinPasswordLength(): int
    {
        return $this->minPasswordLength;
    }
}
