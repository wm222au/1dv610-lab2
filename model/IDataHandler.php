<?php

namespace Model;

interface IDataHandler
{
    public function query(string $queryString);
    public function getResults();
}
