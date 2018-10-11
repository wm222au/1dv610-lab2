<?php

namespace Helpers;

class Auth
{
    private static $hashOptions = ['cost' => 20];

    public static function hash(string $clearTextPassword): string
    {
        return password_hash($clearTextPassword, PASSWORD_BCRYPT, SELF::$hashOptions);
    }
}
