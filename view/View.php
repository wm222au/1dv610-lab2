<?php

namespace View;

abstract class View
{
    public static $viewUrl = "";

    abstract public function toHTML(): string;
    abstract protected function response(): string;
}
