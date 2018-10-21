<?php

namespace Model;

class LoginFacade
{
    private $userRegistry;
    private $userSession;

    private $loggedInByToken = false;

    public function __construct(\Model\DAL\UserDALMySQL $userRegistry, \Model\SessionHandler $userSession)
    {
        $this->userRegistry = $userRegistry;
        $this->userSession = $userSession;
    }

    public function isLoggedIn(): bool
    {
        return $this->userSession->exists();
    }

    public function loggedInByToken(): bool
    {
        return $this->loggedInByToken;
    }

    public function logoutUser()
    {
        $this->userSession->deleteEntry();
    }

    public function loginWithUserThrowsOnFail(\Model\UserCredentials $toBeLoggedIn)
    {
        if($toBeLoggedIn->isValid()) {
            $this->tryToLoginWithUser($toBeLoggedIn);
        } else {
            throw new UserValidationFailure($toBeLoggedIn);
        }
    }

    public function loginWithTokenThrowsOnFail(string $token)
    {
        if($this->userRegistry->compareToken($token)) {
            $this->loggedInByToken = true;
            $this->userSession->saveEntry(new \Model\UserCredentials());
        }

        return false;
    }

    private function tryToLoginWithUser(\Model\UserCredentials $toBeLoggedIn)
    {
        if($this->userRegistry->compareUser($toBeLoggedIn)) {
            $this->userRegistry->updateToken($toBeLoggedIn);
            $this->userSession->saveEntry($toBeLoggedIn);
        }
    }
}