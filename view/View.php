<?php

namespace View;

abstract class View
{
    abstract public function toHTML($model): string;
    abstract protected function response(): string;
}
