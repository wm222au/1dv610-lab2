<?php

class UserDALMySQL implements \Model\IUserDAL
{
    private $db;

    public function __construct(\Helpers\MySQL_instance $database)
    {
        $this->db = $database;
    }

    public function getAll(): array
    {

    }

    public function get(): array
    {

    }
}
