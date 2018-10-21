<?php

namespace Model;

class RegisterPasswordsNotEqual extends \Exception {}

class RegisterFacade
{
    private $userRegistry;

    private $registrationSuccessful = false;

    public function __construct(\Model\DAL\UserDALMySQL $userRegistry)
    {
        $this->userRegistry = $userRegistry;
    }

    public function registrationWasSuccessful(): bool
    {
        return $this->registrationSuccessful;
    }

    public function registerAccount(\Model\UserCredentials $toBeRegistered, $repeatedPassword)
    {
        if(!$toBeRegistered->isValid()) {
            throw new UserValidationFailure($toBeRegistered);
        } else if ($toBeRegistered->getPassword() !== $repeatedPassword) {
            throw new RegisterPasswordsNotEqual();
        } else {
            $this->userRegistry->add($toBeRegistered);
            $this->registrationSuccessful = true;
        }
    }
}