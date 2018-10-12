<?php

namespace View;

abstract class View
{
    public static $viewUrl = "";
    private $errors = array();

    // abstract protected function createUserFeedback(string $feeback);
    abstract public function toHTML(): string;
    // abstract protected function response(): string;
}
