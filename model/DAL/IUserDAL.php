<?php

namespace Model\DAL;

interface IUserDAL
{
    public function getById(string $id): array;
    public function add(\Model\UserCredentials $userCredentials);
    public function compareUser(\Model\User $user): bool;
    public function compareToken(string $token): bool;
    public function updateToken(\Model\UserCredentials $userCredentials);
}
