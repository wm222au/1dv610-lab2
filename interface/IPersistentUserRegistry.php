<?php

namespace Interfaces;

interface IPersistentUserRegistry
{
    public function getUser($user): \Model\User;
    public function hasUser($user): \Model\User;
    public function addUser($user): \Model\User;
}
