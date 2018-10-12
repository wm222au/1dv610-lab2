<?php

namespace Interfaces;

interface IPersistentRegistry
{
    public function get($object);
    public function exists($object);
    public function compare($object);
    public function add($object);
}
