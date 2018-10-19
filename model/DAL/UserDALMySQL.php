<?php

class UserDALMySQL implements \Model\IUserDAL
{
    private $db;

    public function __construct(\Helpers\MySQL_instance $database)
    {
        $this->db = $database;
    }
}
