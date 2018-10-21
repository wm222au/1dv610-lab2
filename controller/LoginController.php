<?php

namespace Controller;

use Helpers\AuthUtilities;
use Model\DAL\DatabaseFailure;
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
        } catch(\Exception $exception) {
            return $this->determineErrorRendering($exception);
        } catch (\Error $error) {
            return $this->determineErrorRendering(new DatabaseFailure(-1));
        }

        return $this->view->toHTML();
    }

    private function handleUserAction()
    {
        if ($this->view->userWillLoginViaForm()) {
            $this->loginViaForm();
        }
        else if ($this->view->userWillLoginViaCookie() && !$this->model->isLoggedIn()) {
            $this->loginViaToken();

        } else if ($this->view->userWillLogout()) {
            $this->logoutUser();
        }
    }

    private function determineErrorRendering(\Exception $e): string
    {
        if ($e instanceof UserValidationFailure) {
            return $this->view->validationErrorToHTML($e->getUserValidation());
        } else {
            return $this->view->loginErrorToHTML($e);
        }
    }

    private function loginViaForm()
    {
        $user = $this->view->getUserObject();

        $userCredentials = new \Model\UserCredentials();
        $userCredentials->setUsername($user->getUsername());
        $userCredentials->setPassword($user->getPassword());
        $userCredentials->setToken(AuthUtilities::randomString());

        $this->model->loginWithUserThrowsOnFail($userCredentials);

        // We set token either way, but only save to client if user wishes to
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
        $this->model->logoutUser();
        $this->view->unsetCookie();
    }
}
