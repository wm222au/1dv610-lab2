<?php

namespace Model\Registry;

abstract class PersitentUserRegistry implements IPersistentUserRegistry
{
    private static $hashOptions = ['cost' => 20];

    private static function hash(string $clearTextPassword): string
    {
        return password_hash($clearTextPassword, PASSWORD_BCRYPT, SELF::$hashOptions);
    }
}
