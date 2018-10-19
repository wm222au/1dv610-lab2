<?php

namespace Model\DAL;

interface IUserDAL
{
    public function getAll(): array;
    public function get(): array;
}
