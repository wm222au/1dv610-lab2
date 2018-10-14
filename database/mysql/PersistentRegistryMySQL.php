<?php

namespace Database;

abstract class PersistentRegistryMySQL implements \Database\IPersistentRegistry
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
}
