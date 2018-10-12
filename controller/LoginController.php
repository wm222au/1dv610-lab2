<?php

namespace Controller;

class LoginController extends Controller
{
    private $view;
    private $userRegistry;
    private $tokenRegistry;

    public function __construct(\Database\PersistentRegistryFactory $factory)
    {
        $this->view = new \View\LoginView();
        $this->userRegistry = $factory->build($this->getClassName(\Model\User::class));
        $this->tokenRegistry = $factory->build($this->getClassName(\Model\Token::class));
    }

    public function index(): \View\View
    {
        if ($this->view->userWillLogin()) {
            return $this->attemptLogin();
        } else if ($this->view->userWillLogout()) {
            return $this->attemptLogout($this->view->getUserLogout());
        }

        return $this->showForm();
    }

    private function attemptLogin()
    {
        // set newUser cookie & session via session model
        try {
            $user = $this->view->getUserLogin();
            $this->authenticateClient($user);
        } catch (\Exception $e) {

        }
        return $this->showForm();
    }

    private function authenticateClient($user)
    {

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
