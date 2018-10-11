<?php

namespace Interfaces;

interface IPersistentRegistry
{
    public function get($object);
    public function exists($object);
    public function add($object);
}
