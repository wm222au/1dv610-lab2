<?php

namespace Database;

abstract class PersitentRegistryFactory
{
    private $dataSource;

    abstract public function __construct($dataSource);

    abstract public function build($registryType);
}
