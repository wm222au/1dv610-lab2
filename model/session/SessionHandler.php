<?php

namespace Model;

session_start();

class SessionHandler
{
    private $sessionKey;

    public function __construct(string $sessionKey)
    {
        $this->sessionKey = $sessionKey;
    }

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
        }
    }

    public function saveEntry($toBeSaved)
    {
        $_SESSION[$this->sessionKey] = $toBeSaved;
    }

    public function deleteEntry()
    {
        unset($_SESSION[$this->sessionKey]);
    }
}
