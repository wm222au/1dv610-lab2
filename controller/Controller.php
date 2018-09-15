<?php

namespace Controller;

class Controller
{
    public function index(): string
    {
        if (isset($this->view)) {
            return $this->view->toHTML();
        } else {
            return "Not implemented yet.";
        }
    }
}
