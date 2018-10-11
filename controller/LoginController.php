<?php

namespace Controller;

class LoginController extends Controller
{
    private $view;
    private $userRegistry;
    private $tokenRegistry;

    public function __construct(\Database\PersitentRegistryFactory $factory)
    {
        $this->view = new \View\LoginView();
        $this->userRegistry = $factory->build("User");
        $this->tokenRegistry = $factory->build("Token");
    }

    public function index(): \View\View
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
        // $userCredentials = $this->userRegistry->getUser($user);
        // $this->registry->getUser($userCredentials);
        // set newUser cookie & session via session model
        return $this->showForm();
    }

    private function attemptLogout()
    {
        // is logged in
        // if ($loginModel->getIsLoggedIn()) {
        //     // logout

        // }
        return $this->showForm();
    }

    private function showForm(): \View\View
    {
        return $this->view;
    }
}
