<?php

namespace Model;

interface IUserDAL
{
    public function getAll(): array;
    public function get(): array;
}
