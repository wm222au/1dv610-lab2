<?php

namespace Model;

class Register
{
    private $user;

    private $usernameLengthValid = false;
    private $passwordLengthValid = false;
    private $passwordsEqual = false;
    private $userExists = false;
    private $userRegistration = false;

    private $minUsernameLength;
    private $minPasswordLength;

    public function __construct(\Model\User $user, $repeatedPassword)
    {
        $this->user = $user;

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

    public function getUsernameCharsAreValid(): bool
    {
        return strip_tags($this->user->getUsername()) == $this->user->getUsername();
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

    private function setUserExists(bool $exists): bool
    {
        return $this->userExists = $exists;
    }

    public function getUserExists(): bool
    {
        return $this->userExists;
    }

    private function setUserRegistration(bool $isReg): bool
    {
        return $this->userRegistration = $isReg;
    }

    public function getUserRegistration(): bool
    {
        return $this->userRegistration;
    }

    public function registerUser()
    {
        if ($this->getPasswordsEqual() && $this->getUsernameCharsAreValid()) {
            try {
                if ($this->user->registerUserToDatabase()) {
                    $this->setUserRegistration(true);
                    return true;
                } else {
                    $this->setUserExists(true);
                }
            } catch (Exception $error) {
                $this->setUserRegistration(false);
            }
        }
        return false;
    }
}
