<?php

namespace Helpers;

class PathUtilities
{
    public static function getClassName(string $class)
    {
        $path = explode('\\', $class);
        return array_pop($path);
    }
}
