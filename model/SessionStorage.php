<?php

namespace Model;

session_start();

class SessionStorage
{
    private $modelType;
    private $sessionKey;

    public function __construct($modelType, string $key)
    {
        $this->modelType = 'Model\\' . $modelType;
        $this->sessionKey = $key;
    }

    private function getSessionKey(): string
    {
        return $this->key;
    }

    public function exists(): bool
    {
        return isset($_SESSION[$this->key]);
    }

    public function loadEntry()
    {
        if ($this->exists()) {
            return $_SESSION[$this->key];
        } else {
            return new $this->modelType();
        }
    }

    public function saveEntry(User $toBeSaved)
    {
        $_SESSION[$this->key] = $toBeSaved;
    }

    public function deleteEntry()
    {
        unset($_SESSION[$this->key]);
    }
}
