<?php

namespace Database;

class PersistentRegistryMySQLFactory extends \Database\PersistentRegistryFactory
{
    public function __construct($dataSource)
    {
        $this->dataSource = $dataSource;
    }

    public function build($registryType)
    {
        switch ($registryType) {
            case "User":
                return new \Database\PersistentUserRegistryMySQL($this->dataSource);
            case "Token":
                return new \Database\PersistentTokenRegistryMySQL($this->dataSource);
            default:
                throw new Exception("Failed to create class");
        }
    }
}
