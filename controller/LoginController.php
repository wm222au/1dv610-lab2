<?php

namespace Controller;

class LoginController implements Controller
{
    private $view;
    private $session;

    public function __construct(\View\LoginView $view, \Model\SessionHandler $session)
    {
        $this->view = $view;
        $this->session = $session;
    }

    public function index(): string
    {
        if ($this->view->userWillLoginViaForm()) {
            return $this->loginWithCredentials($this->view->getUserObject());
        } else if ($this->view->userWillLoginViaCookie()) {
            return $this->loginWithToken($this->view->getCookieToken());
        } else if ($this->view->userWillLogout()) {
            return $this->logoutUser($this->view->getUserLogout());
        }

        return $this->showForm();
    }

    private function loginWithCredentials(\Model\Login $loginModel)
    {
        $loginModel->loginUser();
        return $this->view->toHTML($loginModel);
    }

    private function loginWithToken(string $token)
    {
        // create token either way
        $token = \Helpers\AuthUtilities::randomString();

        // only store cookie if user requested it
        if ($this->view->userWillBeRemembered()) {
            $this->view->remeberUserWithToken($token);
        }

        // try to login user

    }

    private function logoutUser(\Model\Login $loginModel)
    {
        if ($loginModel->getIsLoggedIn()) {
            $loginModel->logoutUser();
            return $this->view->toHTML($loginModel);
        } else {
            return $this->showForm();
        }
    }

    private function showForm(): string
    {
        return $this->view->toHTML(null);
    }
}
