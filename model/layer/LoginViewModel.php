<?php

namespace Model;

class LoginViewModel implements IViewModel
{
    private $isUsernameEmpty = false;
    private $isPasswordEmpty = false;
    private $isCredentialsWrong = false;
    private $userHasLoggedIn = false;
    private $userHasLoggedOut = false;

    public function getIsUsernameEmpty(): bool
    {
        return $this->isUsernameEmpty;
    }

    public function getIsPasswordEmpty(): bool
    {
        return $this->isPasswordEmpty;
    }

    public function getIsCredentialsWrong(): bool
    {
        return $this->isCredentialsWrong;
    }

    public function getUserHasLoggedIn(): bool
    {
        return $this->userHasLoggedIn;
    }

    public function getUserHasLoggedOut(): bool
    {
        return $this->userHasLoggedOut;
    }

    public function setUserHasLoggedIn()
    {
        return $this->userHasLoggedIn = true;
    }

    public function setUserHasLoggedOut()
    {
        return $this->userHasLoggedOut = true;
    }

    public function handleError(\Exception $exception)
    {
        if ($exception instanceof \Model\UsernameEmptyException) {
            $this->isUsernameEmpty = true;

        } else if ($exception instanceof \Model\PasswordEmptyException) {
            $this->isPasswordEmpty = true;

        } else {
            $this->isCredentialsWrong = true;
        }
    }
}
