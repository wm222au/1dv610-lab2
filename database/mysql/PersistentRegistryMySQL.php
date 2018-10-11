<?php

namespace Database;

abstract class PersistentRegistryMySQL
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
}
