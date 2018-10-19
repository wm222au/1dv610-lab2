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
        $this->userSession->exists();
    }

    public function loggedInByToken(): bool
    {
        return $this->loggedInByToken;
    }

    public function loginWithUserThrowsOnFail(\Model\UserCredentials $toBeLoggedIn)
    {
        $user = $toBeLoggedIn->getUser();

        $userLogin = new \Model\UserValidation();
        $userLogin->setUsername($user->getUsername());
        $userLogin->setPassword($user->getPassword());

        if($userLogin.isValid()) {
            $this->tryToLoginWithUser($toBeLoggedIn);
        } else {
            throw new UserValidationFailure($userLogin);
        }
    }

    public function loginWithTokenThrowsOnFail(string $token)
    {
        if($this->userRegistry->compareToken($token)) {
            $this->loggedInByToken = true;
        }

        return false;
    }

    private function tryToLoginWithUser(\Model\UserCredentials $toBeLoggedIn)
    {
        if($this->userRegistry->compareUser($toBeLoggedIn)) {
            $this->userRegistry->updateToken($toBeLoggedIn);
        }
    }
}