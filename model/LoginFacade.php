<?php

namespace Model;

class LoginFacade
{
    private $userRegistry;
    private $userLogin;
    private $databaseFailure;

    public function __construct(\Model\DAL\UserDALMySQL $userRegistry)
    {
        $this->userRegistry = $userRegistry;
    }

    public function getUserLogin(): \Model\UserValidation
    {
        return $this->userLogin;
    }

    public function getDatabaseFailure(): \Helpers\DatabaseFailure
    {
        return $this->databaseFailure;
    }

    public function loginUserThrowsOnFail(\Model\UserCredentials $toBeLoggedIn): bool
    {
        $user = $toBeLoggedIn->getUser();

        $this->userLogin = new \Model\UserValidation();
        $this->userLogin->setUsername($user->getUsername());
        $this->userLogin->setPassword($user->getPassword());

        if($this->userLogin.isValid()) {
            return $this->tryToLoginUser($user);
        } else {
            throw new \Exception("User credentials are not valid.");
        }
    }


    private function tryToLoginUser(\Model\User $userParams): string
    {
        try {
            $this->authorizeUser($userParams);
        } catch (\DatabaseFailure $e) {
            return $this->view->showLoginError($e);
        }
    }

    private function authorizeUser(\Model\User $userParams): string
    {
        $token = AuthUtilities::randomString();
        $this->loginWithUserObject($userParams, $token);
        if($this->view->userWantsToBeRemembered()) {
            $this->view->setCookie($token);
        }
    }
}