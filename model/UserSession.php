<?php

class UserSession
{
    private $_storage;

    public function __construct()
    {
        $this->_storage = new \Model\Session("UserStorage");
    }
}
