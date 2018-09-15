<?php

namespace Model;

session_start();

class SessionStorage
{
    private static $SESSION_KEY = "1dv610lab2";
    private $modelType;

    public function __construct($modelType)
    {
        $this->modelType = 'Model\\' . $modelType;
    }

    private function getSessionKey(): string
    {
        return self::$SESSION_KEY;
    }

    public function exists(): bool
    {
        return isset($_SESSION[self::$SESSION_KEY]);
    }

    public function loadEntry()
    {
        if (isset($_SESSION[self::$SESSION_KEY])) {
            return $_SESSION[self::$SESSION_KEY];
        } else {
            return new $this->modelType();
        }
    }

    public function saveEntry(User $toBeSaved)
    {
        $_SESSION[self::$SESSION_KEY] = $toBeSaved;
    }

    public function deleteEntry()
    {
        unset($_SESSION[self::$SESSION_KEY]);
    }
}
