<?php

namespace Controller;

class LoginController extends Controller
{
    private $view;

    public function __construct()
    {
        $this->view = new \View\LoginView();
    }

    public function index(): string
    {
        if ($this->view->userWillLogin()) {
            return $this->loginUser($this->view->getLogin());
        } else if ($this->view->userWillLogout()) {

        } else {
            return $this->showForm();
        }
    }

    private function loginUser(\Model\Login $loginModel)
    {
        $loginModel->loginUser();
        return $this->view->toHTML($loginModel);
    }

    private function logoutUser(\Model\Login $loginModel)
    {
        $loginModel->loginUser();
        return $this->view->toHTML($loginModel);
    }

    private function showForm(): string
    {
        return $this->view->toHTML(null);
    }
}
