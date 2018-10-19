<?php

namespace Model;

class UserCredentials
{
    private $token;
    private $user;

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token)
    {
        $this->token = $token;
    }

    public function getUser(): \Model\User
    {
        return $this->user;
    }

    public function setUser(\Model\User $user)
    {
        $this->user = $user;
    }


}