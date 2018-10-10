<?php

namespace View;

abstract class View
{
    private $errors = array();
    abstract public function toHTML($model): string;
    abstract protected function response(): string;
}
