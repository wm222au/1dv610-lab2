<?php

namespace Model;

session_start();

class UserStorage
{
    private $sessionKey = "UserStorage";

    public function getSessionKey(): string
    {
        return $this->sessionKey;
    }

    public function exists(): bool
    {
        return isset($_SESSION[$this->sessionKey]);
    }

    public function loadEntry()
    {
        if ($this->exists()) {
            return $_SESSION[$this->sessionKey];
        } else {
            return new \Model\User();
        }
    }

    public function saveEntry(User $toBeSaved)
    {
        $_SESSION[$this->sessionKey] = $toBeSaved;
    }

    public function deleteEntry()
    {
        unset($_SESSION[$this->sessionKey]);
    }
}
