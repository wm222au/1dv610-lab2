<?php

namespace Controller;

class LoginController extends Controller
{
    private $view;

    public function __construct()
    {
        $this->view = new \View\LoginView();
        $this->registry = new \Model\Registry\PersitentUserRegistry();
    }

    public function index(): string
    {
        if ($this->view->userWillLogin()) {
            return $this->attemptLogin($this->view->getUserLogin());
        } else if ($this->view->userWillLogout()) {
            return $this->attemptLogout($this->view->getUserLogout());
        }

        return $this->showForm();
    }

    private function attemptLogin(\Model\User $user)
    {
        // login
        $userCredentials = $this->registry->getUser($user);
        // $this->registry->getUser($userCredentials);
        // set newUser cookie & session via session model
        return $this->showForm();
    }

    private function attemptLogout()
    {
        // is logged in
        if ($loginModel->getIsLoggedIn()) {
            // logout

        }
        return $this->showForm();
    }

    private function showForm(): string
    {
        return $this->view->toHTML();
    }
}
