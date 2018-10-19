<?php

namespace Controller;


class NavigationController implements Controller
{
    private $db;

    public function __construct(\Helpers\IDAL $database)
    {
        $this->db = $database;
    }

    public function index(): string
    {

    }
}