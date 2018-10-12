<?php

namespace Model;

interface IViewModel
{
    public function handleError(\Exception $e);
}
