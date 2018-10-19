<?php

namespace Helpers;

class AuthUtilities
{
    private static $hashOptions = ['cost' => 12];

    public static function hash(string $clearTextPassword): string
    {
        return password_hash($clearTextPassword, PASSWORD_BCRYPT, SELF::$hashOptions);
    }

    public static function randomString(int $length = 24)
    {
        $token = openssl_random_pseudo_bytes($length);

        $token = bin2hex($token);

        return $token;
    }
}
