<?php

namespace View;

class CookieHandler
{
    private $cookieName;

    public function __construct(string $cookieName = "cookie")
    {
        $this->cookieName = $cookieName;
    }

    public function exists(): bool
    {
        return isset($_COOKIE[$this->cookieName]);
    }

    public function loadEntry()
    {
        if ($this->exists()) {
            return $_COOKIE[$this->cookieName];
        }
    }

    public function saveEntry($data)
    {
        setcookie($this->cookieName, $data, time() + (86400 * 30));
    }

    public function deleteEntry()
    {
        setcookie($this->cookieName, "", time() - (86400 * 30));
    }
}
