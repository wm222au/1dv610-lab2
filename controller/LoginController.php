<?php

namespace Controller;

use Helpers\AuthUtilities;
use Model\UserValidationFailure;

class LoginController implements Controller
{
    private $view;
    private $model;

    public function __construct(\View\LoginView $view, \Model\LoginFacade $toBeViewed)
    {
        $this->view = $view;
        $this->model = $toBeViewed;
    }

    public function index(): string
    {
        try {
            $this->handleUserAction();
        } catch(\Exception $e) {
            return $this->determineErrorRendering($e);
        }

        return $this->view->toHTML();
    }

    private function handleUserAction()
    {
        if ($this->view->userWillLoginViaForm()) {
            $this->loginViaForm();
        }
        else if ($this->view->userWillLoginViaCookie()) {
            $this->loginViaToken();

        } else if ($this->view->userWillLogout()) {
            $this->logoutUser();
        }
    }

    private function determineErrorRendering(\Exception $e): string
    {
        if ($e instanceof UserValidationFailure) {
            return $this->view->validationErrorToHTML($e->getUserValidation());
        } else if ($e instanceof  \DatabaseFailure){
            return $this->view->loginErrorToHTML($e);
        }
    }

    private function loginViaForm()
    {
        $user = $this->view->getUserObject();

        $userCredentials = new \Model\UserCredentials();
        $userCredentials->setUser($user);
        $userCredentials->setToken(AuthUtilities::randomString());

        $this->model->loginWithUserThrowsOnFail($userCredentials);

        if($this->view->userWantsToBeRemembered()) {
            $this->view->setCookie($userCredentials->getToken());
        }
    }

    private function loginViaToken()
    {
        $token = $this->view->getCookieToken();

        $this->model->loginWithTokenThrowsOnFail($token);

        $this->view->setCookie($token);
    }

    private function logoutUser()
    {
        // remove token
        // unset cookie
        // unset session
    }
}
