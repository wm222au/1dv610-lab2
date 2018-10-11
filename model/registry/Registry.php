<?php

namespace Model\Registry;

class Registry
{
    private $db;

    public function __construct(\Model\IDataHandler $db)
    {
        $this->db = $db;
    }
}
