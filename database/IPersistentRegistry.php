<?php

namespace Database;

interface IPersistentRegistry
{
    public function get($object);
    public function exists($object);
    public function compare($object);
    public function add($object);
}
