<?php

namespace Model;

session_start();

class Session
{
    private $_sessionKey;

    public function __construct($sessionKey)
    {
        $this->_sessionKey = $sessionKey;
    }

    public function getSessionKey(): string
    {
        return $this->_sessionKey;
    }

    public function exists(): bool
    {
        return isset($_SESSION[$this->_sessionKey]);
    }

    public function loadEntry()
    {
        if ($this->exists()) {
            return $_SESSION[$this->_sessionKey];
        }
    }

    public function saveEntry($toBeSaved)
    {
        $_SESSION[$this->_sessionKey] = $toBeSaved;
    }

    public function deleteEntry()
    {
        unset($_SESSION[$this->_sessionKey]);
    }
}
