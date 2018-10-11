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

    private function userWantsLogin()
    {
        // check if user is posting login
        // else check if cookie exists (via view - handle as IN-DATA)
        // how handle "welcome back with cookie"?
    }

    private function attemptLogin(\Model\User $user)
    {
        // login
        $newUser = $this->registry->getUser($user);
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
