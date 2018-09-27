<?php

namespace Model;

use Exception;

class Login
{
    private $user;

    private $isAuthenticated = false;
    private $isLoggedOut = false;
    private $userExists = true;

    public function __construct(\Model\User $user)
    {
        $this->user = $user;
    }

    public function getIsLoggedIn(): bool
    {
        return $this->user->getIsLoggedIn();
    }

    public function getIsUsernameEmpty(): bool
    {
        return $this->user->isUsernameEmpty();
    }

    public function getIsPasswordEmpty(): bool
    {
        return $this->user->isPasswordEmpty();
    }

    private function setIsAuthenticated(bool $isReg): bool
    {
        return $this->userRegistration = $isReg;
    }

    public function getIsAuthenticated(): bool
    {
        return $this->userRegistration;
    }

    private function setIsLoggedOut(bool $isLoggedOut)
    {
        return $this->isLoggedOut = $isLoggedOut;
    }

    public function getIsLoggedOut()
    {
        return $this->isLoggedOut;
    }

    private function setUserExists(bool $exists): bool
    {
        return $this->userExists = $exists;
    }

    public function getUserExists(): bool
    {
        return $this->userExists;
    }

    public function logoutUser()
    {
        if ($this->user->logoutUser()) {
            $this->setIsLoggedOut(true);
        }
    }

    public function loginUser()
    {
        try {
            if ($this->user->loginUser()) {
                $this->setIsAuthenticated(true);
            } else {
                $this->setIsAuthenticated(false);
            }
        } catch (Exception $error) {
            $this->setIsAuthenticated(false);
        }
    }
}
