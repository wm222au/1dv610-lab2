<?php

namespace Inter;

interface IPersistentUserRegistry
{
    public function getUser($user): \Model\User;
    public function hasUser($user): bool;
    public function addUser($user);
}
