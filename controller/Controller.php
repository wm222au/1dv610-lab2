<?php

namespace Controller;

abstract class Controller
{
    abstract public function index(): \View\View;

    protected function getClassName(string $class)
    {
        $path = explode('\\', $class);
        return array_pop($path);
    }
}
