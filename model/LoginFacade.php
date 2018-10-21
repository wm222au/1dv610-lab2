<?php

namespace Model;

class WrongLoginCredentials extends \Exception {}

class LoginFacade
{
    private $userRegistry;
    private $userSession;

    private $loggedInByUser = false;
    private $loggedInByToken = false;
    private $wasLoggedOut = false;

    public function __construct(\Model\DAL\UserDALMySQL $userRegistry, \Model\SessionHandler $userSession)
    {
        $this->userRegistry = $userRegistry;
        $this->userSession = $userSession;
    }

    public function isLoggedIn(): bool
    {
        return $this->userSession->exists();
    }

    public function wasLoggedInByUser(): bool
    {
        return $this->loggedInByUser;
    }

    public function wasLoggedInByToken(): bool
    {
        return $this->loggedInByToken;
    }

    public function wasLoggedOut(): bool
    {
        return $this->wasLoggedOut;
    }

    public function logoutUser()
    {
        $this->userSession->deleteEntry();
        $this->wasLoggedOut = true;
    }

    public function loginWithUserThrowsOnFail(\Model\UserCredentials $toBeLoggedIn)
    {
        if($toBeLoggedIn->isValid()) {
            $this->loggedInByUser = true;
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
        } else {
            throw new WrongLoginCredentials();
        }
    }
}