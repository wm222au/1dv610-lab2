<?php

namespace Inter;

interface IPersistentTokenRegistry
{
    public function getToken($token): string;
    public function hasToken($token): bool;
    public function addToken($token);
}
