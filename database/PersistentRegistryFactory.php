<?php

namespace Database;

abstract class PersistentRegistryFactory
{
    private $dataSource;

    abstract public function __construct($dataSource);

    abstract public function build($registryType);
}
