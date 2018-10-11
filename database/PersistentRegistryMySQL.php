<?php

namespace Database;

abstract class PersistentRegistryMySQL
{
    private $db;

    public function __construct(mysqli $db)
    {
        $this->db = $db;
    }
}
