<?php

namespace Interfaces;

interface IPersistentTokenRegistry
{
    public function getToken($token): \Model\User;
    public function hasToken($token): \Model\User;
    public function addToken($token): \Model\User;
}
